<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Goods;          // 实例化一个商品表
use App\Model\Brand;          //品牌表
use App\Model\Classify;       //分类表
use Validator;          // 验证器
use App\Model\Area;           // 实例化一个三级联动的表
use App\Model\Attr;           //属性
use App\Model\GoodsAttr;      //商品属性
use App\Model\Type;           //类型
use Illuminate\Support\Facades\Cache; //引入缓存
class GoodsConrtoller extends Controller{
    // 添加视图
    public function index(){
        // 查询分类表的所有数据
        $data = Classify::get();
        // 调用无限极分类
        $getclass = getclassify($data);
        // 品牌表
        $Brands = Brand::get();
        // 三级联动的表
        $Areas = Area::where(['pid'=>0])->get();
        // 属性表
        $Typesdata = Type::get();
        return view('admin/goods/index', ['getclass'=>$getclass,'brands'=>$Brands,'Areas'=>$Areas,'Typesdata'=>$Typesdata]);
    }

    // 三级联动
    public function getAera(){
        // 接值
        $id = request()->id;
        // sql
        $son = Area::where(['pid'=>$id])->get()->toArray();
        // 给一个数组
        $result = [
            'code'=>'00000',
            'data'=>$son
        ];
        // 输出一个json串
        echo json_encode($result);
        exit;
    }

    // 属性
    public function getAttr(){
        $type_id = request()->get('type_id');
        $attrdate = Attr::where(['type_id'=>$type_id])->get()->toArray();
        return json_encode($attrdate);
    }

    // 执行添加
    public function add(){
        $post = request()->except('_token');
        // 验证
        // 接收全部的值
        $Validator = Validator::make($post, [
            // 验证规则  如果要是验证规则没有的话就用regex
            'goods_name' => 'required|unique:Goods|between:1,9',
            'goods_price' => 'required|integer',
            // 'goods_reper' => 'required|integer',
            'goods_intr' => 'required|between:5,50',
        ], [
            // 自定义报错信息
            'goods_name.required' =>'商品名称不能为空',
            'goods_name.unique' =>'商品名称不能重复',
            'goods_name.between' =>'商品名称在1~9之内',
            'goods_price.required' =>'价格不能为空',
            'goods_price.integer' =>'价格必须是整数',
            // 'goods_reper.required' =>'库存不能为空',
            // 'goods_reper.integer' =>'库存必须是整数',
            'goods_intr.required' =>'品牌描述不能为空',
            'goods_intr.between' =>'品牌描述在5~50之间',
        ]);
        // 判断是否有误有误的话就给报错提示
        if ($Validator->fails()) {
            unset($post['goods_log']);
            unset($post['goods_logs']);
            
            return redirect('Goods/index')
           // 报错默认
           ->with('data', $post)
           ->withErrors($Validator)
           ->withInput();
        }
        //时间
        $goods_thim = $post['goods_thim'] = date('Y-m-d h:i:s', time());
        // 文件上传，hasFile判断文件在请求中是否存在
        if (request()->hasFile('goods_log')) {
            // echo 123;die;
            $post['goods_log']=unifile('goods_log');
        }
        //  多文件
        if (isset($post['goods_logs'])) {
            $post['goods_logs'] = uploads('goods_logs');
            $post['goods_logs'] = implode('|', $post['goods_logs']);
        }
        // 订单号
        $goods_ltem = $post['goods_ltem'] = goodshao();
        // 添加商品基本信息
        $GoodsData = Goods::create([
            'goods_name'=>$post['goods_name'],
            'goods_price'=>$post['goods_price'],
            'brand_id'=>$post['brand_id'],
            'class_id'=>$post['class_id'],
            'goods_pop'=>$post['goods_pop'],
            'goods_log'=>$post['goods_log'],
            'goods_logs'=>$post['goods_logs'],
            'goods_intr'=>$post['goods_intr'],
            'goods_ltem'=>$goods_ltem,
            'goods_thim'=>$goods_thim,
        ]);
        // 添加商品属性
        $goods_id =  $GoodsData['goods_id'];
        if (!empty($post['attr_id_list'])) {
            foreach ($post['attr_id_list'] as $k=>$v) {
                GoodsAttr::create([
                    'goods_id'=>$goods_id,
                    'attr_id'=>$v,
                    'attr_value'=>$post['attr_value_list'][$k],
                    'attr_price'=>$post['attr_price_list'][$k],
                ]);
            }
        }
        echo "<script>alert('即将跳转到货品页面');location.href='/Sku/index/?goods_id=".$goods_id."'</script>";
        //     //判断是否添加到数据库
        //     if($Goods){
        //         return redirect('Goods/show');
        //     }
        // }
    }

    // Ajax的唯一性
    function ajaxsole(){
            // 接收值
            $goods_name = request()->get('goods_name');
            // where条件查询
            $where = [];
            if (!empty($goods_name)) {
                $where[] = ['goods_name','=',$goods_name];
            };
            // 查询一个字段
            $count = Goods::where($where)->count();
            // 判断查询到的值是否大于零，大于零的话就是查询到了
            if ($count>0) {
                echo "on";
            } else {
                echo "ok";
            }
    }

    // 列表展示
    function show(){
            //读取缓存
            $get = cache('get');
            // 判断缓存是否有数据
            if(!$get){
                $get = Goods::select('goods.*', 'brand.brand_name', 'classify.class_name')
                        ->leftjoin('brand', 'goods.brand_id', '=', 'brand.brand_id')
                        ->leftjoin('classify', 'goods.class_id', '=', 'classify.class_id')
                        ->paginate(20);
                // 存入缓存
                Cache(['get'=>$get],300);
            }
            // 多文件上传处理
            foreach ($get as $v) {
                $v->goods_logs = explode('|', $v->goods_logs);
            }
            // 收获地址
            if ($get) {
                foreach ($get as $k=>$v) {
                    $get[$k]->sheng = Area::where('id', $v->sheng)->value('name');
                    $get[$k]->shi = Area::where('id', $v->shi)->value('name');
                    $get[$k]->qu = Area::where('id', $v->qu)->value('name');
                }
            }
            return view('admin/goods/show', ['get'=>$get]);
    }

    // 极点技改
    function ajaxunp(){
            echo "极点技改";
    }

    // 删除
    function del($id){
            echo "删除";
    }

    // 修改视图
    function unp($id){
            echo "修改视图";
    }

    // 执行修改
    function ubps($id){
            echo "执行修改";
    }
    
}
