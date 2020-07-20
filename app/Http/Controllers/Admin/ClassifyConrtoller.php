<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//实例化一个商品分类的model
use App\Model\Classify;
// 验证器
use Validator;

class ClassifyConrtoller extends Controller{
    //商品添加视图页面
    function index(){
        // 查询分类表的所有数据
        $data = Classify::get();
        // 调用无限极分类
        $getclass = getclassify($data);
        return view('admin/classify/index',['getclass'=>$getclass]);
    }

    // 执行添加
    function add(){
        // 接收值
        $post = request()->except('_token');
        // 验证
        // 接收全部的值
        $Validator = Validator::make($post,[
            // 验证规则  如果要是验证规则没有的话就用regex
            'class_name' => 'required|unique:Classify|between:1,9',
            'class_ant' => 'required|between:1,9',
            'class_desc' => 'required|between:3,50',
        ],[
            // 自定义报错信息
            'class_name.required' =>'分类名称不能为空',
            'class_name.unique' =>'分类名称不能重复',
            'class_name.between' =>'分类名称在1~9之内',
            'class_ant.required' =>'关键字不能为空',
            'class_ant.between' =>'关键字在1~9之内',
            'class_desc.required' =>'分类描述不能为空',
            'class_desc.between' =>'分类描述在3~50之间',
        ]);
        // 判断是否有误有误的话就给报错提示
        if ($Validator->fails()) {
            return redirect('Admins/index')
            // 报错默认
            ->with('data',$post)
            ->withErrors($Validator)
            ->withInput();
        }
        $ins = Classify::insert($post);
        //判断是否添加到数据库
        if($ins){
            return redirect('category/show');
        }
           
    }

    // Ajax的唯一性
    function ajaxsole(){
        // 接收值
        $class_name = request()->get('class_name');
        // where条件查询
        $where[] = ['class_name','=',$class_name];
        // 查询一个字段
        $count = Classify::where($where)->count();
        // 判断查询到的值是否大于零，大于零的话就是查询到了
        if($count>0){
            echo "on";
        }else{
            echo "ok";
        }
        
    }

    // 列表展示
    function show(){
        // 搜索
        $class_name = request()->class_name??'';    //分类名字
        $class_ant = request()->class_ant??'';      //关键字
        $where=[];
        // 让分类名字
        if($class_name){
            $where[]=['class_name','like',"%$class_name%"];
        }// 关键字
        if($class_ant){
            $where[]=['class_ant','like',"%$class_ant%"];
        }
        // 条件保留
        $query = request()->all();
        // 查询分类表的所有数据
        $data = Classify::where($where)->get();
        // 调用无限极分类
        $getclass = getclassify($data);
        return view('admin/classify/show',['getclass'=>$getclass,'data'=>$data,'query'=>$query]);
    }

    // 删除
    function del($id){
        $delete = Classify::where('class_id',$id)->delete();
        if($delete){
            return redirect('category/show');
        }
    }

    // 修改页面
    function unp($id){
        // 查询分类表的所有数据
        $data = Classify::get();
        // 调用无限极分类
        $getclass = getclassify($data);
        $finds = Classify::where('class_id',$id)->first();
        return view('admin/classify/unp',['getclass'=>$getclass,'finds'=>$finds]);
    }

    // 执行修改
    function unps($id){
        //接收值
        $post = request()->except('_token');     
        // 给where条件
        $ins = Classify::where('class_id', $id)->update($post);
        //判断并跳转
        if ($ins!==false) {
            return redirect('category/show');
        }
    }
       
        
}

