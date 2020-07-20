<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Type;
use App\Model\Attr;
use Validator;
class AttrController extends Controller
{
    // 添加视图
    public function index(){
        $getType = Type::get();
        return view('admin.attr.index',['getType'=>$getType]);
    }

    // 添加视图
    public function add(){
        // 接收值
        $post = request()->except('_token');
        // 接收全部的值
        $Validator = Validator::make($post,[
            // 验证规则  如果要是验证规则没有的话就用regex |unique:Type
            'attr_name' => 'required|between:1,9',
        ],[
            // 自定义报错信息
            'attr_name.required' =>'属性不能为空',
            // 'atty_name.unique' =>'类型名称不能重复',
            'attr_name.between' =>'属性字数在1~9之内',
        ]);
        // 判断是否有误有误的话就给报错提示
        if ($Validator->fails()) {
            return redirect('Attr/index')
            // 报错默认
            ->with('data',$post)
            ->withErrors($Validator)
            ->withInput();
        }
        $ins = Attr::insert($post);
        //判断是否添加到数据库
        if($ins){
            return redirect('Attr/show');
        }
    }

    //列表
    public function show(){
        // // 接收值
        $type_id = request()->type_id??'';
        
        // // where条件
        $where = [];
        if($type_id){
            $where[] = ['type.type_id','=',"$type_id"];
        }
        //条件保留
        // 搜索数据
        $dataType = Type::where($where)->get();

        // 列表数据
        $data = type::join('attr','attr.type_id','=','type.type_id')
                    ->where($where)
                    ->paginate(10);
        return view('admin.attr.show',['data'=>$data,'dataType'=>$dataType]);
    }
}
