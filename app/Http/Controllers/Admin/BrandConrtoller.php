<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// brand表
use App\Model\Brand;
// 验证器
use Validator;
class BrandConrtoller extends Controller{
    
    // 添加页面
    function index(){
        return view('admin/brand/index');
    }

    // 执行添加
    function add(){
         // 接收值
         $post = request()->except('_token');
         // 验证
         // 接收全部的值
         $Validator = Validator::make($post,[
             // 验证规则  如果要是验证规则没有的话就用regex
             'brand_name' => 'required|unique:Brand|between:1,9',
             'brand_url' => 'required|regex:/^www\.\w{3,}\.com$/',
             'brand_intr' => 'required|between:1,50',
         ],[
             // 自定义报错信息
             'brand_name.required' =>'品牌名称不能为空',
             'brand_name.unique' =>'品牌名称不能重复',
             'brand_name.between' =>'品牌名称在1~9之内',
             'brand_url.required' =>'品牌网址不能为空',
             'brand_url.regex' =>'品牌网址格式不正确',
             'brand_intr.required' =>'分类描述不能为空',
             'brand_intr.between' =>'分类描述在5~50之间',
         ]);
         // 判断是否有误有误的话就给报错提示
         if ($Validator->fails()) {
            unset($post['brand_log']);
            return redirect('Brand/index')
            // 报错默认
            ->with('data',$post)
            ->withErrors($Validator)
            ->withInput();
         }
         //时间 
        $post['brand_thim'] = date('Y-m-d h:i:s',time());
        // 文件上传，hasFile判断文件在请求中是否存在
        if(request()->hasFile('brand_log')){
            // echo 123;die;
            $post['brand_log']=unifile('brand_log');
        }
    
        $ins = Brand::insert($post);
        //判断是否添加到数据库
        if($ins){
            return redirect('Brand/show');
        }
        
    }

    // ajax唯一性
      // Ajax的唯一性
      function ajaxsole(){
        // 接收值
        $brand_name = request()->get('brand_name');
        $brand_url = request()->get('brand_url');
        // where条件查询
        $where = [];
        if(!empty($brand_name)){
            $where[] = ['brand_name','=',$brand_name];
        };
        if(!empty($brand_url)){
            $where[] = ['brand_url','=',$brand_url];
        };
        
        // 查询一个字段
        $count = Brand::where($where)->count();
        // 判断查询到的值是否大于零，大于零的话就是查询到了
        if($count>0){
            echo "on";
        }else{
            echo "ok";
        }
        
    }

    // 列表展示
    function show(){
         // 接收值
         $brand_name = request()->brand_name??'';
         // where条件
         $where = [];
         if($brand_name){
             $where[] = ['brand_name','like',"%$brand_name%"];
         }
         //条件保留
         $query = request()->all();
         $get = Brand::where($where)->paginate(10);
         return view('admin/brand/show',['get'=>$get,'query'=>$query]);
    }

    // 删除
    function del($id){
        $dels = Brand::where('brand_id',$id)->delete();
        if($dels){
            return redirect('Brand/show');
        }
    }

    // 修改页面
    function unp($id){
       //查询数据，进行数据返回 
       $firsts = Brand::where('brand_id',$id)->first();
       return view('admin/brand/unp',['firsts'=>$firsts]);
    }

    // 执行修改
    function unps($id){
       // 接收值
       $post = request()->except('_token');
       // 验证
       // 接收全部的值
       $Validator = Validator::make($post,[
           // 验证规则  如果要是验证规则没有的话就用regex
           'brand_name' => 'required|between:1,9',
           'brand_url' => 'required|regex:/^www\.\w{3,}\.com$/',
           'brand_intr' => 'required|between:5,50',
       ],[
           // 自定义报错信息
           'brand_name.required' =>'品牌名称不能为空',
           'brand_name.between' =>'品牌名称在1~9之内',
           'brand_url.required' =>'品牌网址不能为空',
           'brand_url.regex' =>'品牌网址格式不正确',
           'brand_intr.required' =>'分类描述不能为空',
           'brand_intr.between' =>'分类描述在5~50之间',
       ]);
       // 判断是否有误有误的话就给报错提示
       if ($Validator->fails()) {
          unset($post['brand_log']);
          return redirect('Brand/index')
          // 报错默认
          ->with('data',$post)
          ->withErrors($Validator)
          ->withInput();
       }
       //时间 
      $post['brand_thims'] = date('Y-m-d h:i:s',time());
      // 文件上传，hasFile判断文件在请求中是否存在
      if(request()->hasFile('brand_log')){
          // echo 123;die;
          $post['brand_log']=unifile('brand_log');
      }
       //添加到数据库
       $ins = Brand::where('brand_id',$id)->update($post);
       //判断并跳转
       if($ins!==false){
           return redirect('Brand/show');
       }
    }

    // 及点击该
    function ajaxunp(){
        // 接收值
        $value = request()->get('_value');
        $find = request()->get('_find');
        $id = request()->get('_id');
        // 验证重复
        $wheres[]= ['brand_name','=',$value];
        $cren =  Brand::where($wheres)->count();
        if($cren==false){
            echo "on";
        }else{
            echo "ok";
        }
        $where[] = ['brand_id','=',$id];
        $arr = [$find=>$value];
        $pards = Brand::where($where)->update($arr);
        if($pards==false){
            echo "no";
        }else{
            echo "ok";
        }
    }
}
