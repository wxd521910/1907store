<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\GoodsAttr;  //商品属性
use App\Model\GoodsSku;   //sku
use App\Model\Goods;      //商品
class SkuController extends Controller{
    //视图
    public function index(){
        $goods_id=request()->goods_id;
        //商品名成和货号
        $goodsdata=Goods::where('goods_id','=',$goods_id)->first();
        $url = env('INDEX.URL').'Login/index';
        if(!$goodsdata){
            echo "<script>alert('非法操作');location.href='$url'</script>";die;
        }
        $attrData=GoodsAttr::join('attr','attr.attr_id','=','goodsattr.attr_id')
                        ->where('goodsattr.goods_id','=',$goods_id)
                        ->where('attr.attr_type','=',1)
                        ->get()
                        ->toArray();
        
        $arr=[];
        foreach ($attrData as $k=>$v){
            $status=$v['attr_name'];  //分组的关键
            $arr[$status][]=$v;
        }
        $sku = [
            'arr'=>$arr,
            'goodsdata'=>$goodsdata
        ];
        
        return view('admin.sku.index',$sku);
    }

    // 添加
    public function add(){
        $data=request()->except('_token');
        //分块处理数据
        // count   统计个数
        $size=count($data['goods_attr_id']) /count($data['goods_num']);
        // 分割 array_chunk
        $attr_value_list=array_chunk($data['goods_attr_id'],$size);
        $newData=[];
        foreach ($data['goods_num'] as $k=>$v){
            $newData[]=[
                'goods_id'=>$data['goods_id'],
                'goods_attr_id'=>implode(',',$attr_value_list[$k]),
                'goods_num'=>$v
            ];
        }
        $res=GoodsSku::insert($newData);
        if($res){
            echo "<script>alert('保存成功');location.href='/Goods/index'</script>";
        }
    }

}
