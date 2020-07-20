<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Model\Type;
use App\Model\Attr;
class TypeController extends Controller
{
    // 添加页面
    public function index(){
        return view('admin.type.index');
    }

    //执行添加
    public function add(){
        // 接收值
        $post = request()->except('_token');
      
        // 验证
        // 接收全部的值
        $Validator = Validator::make($post,[
            // 验证规则  如果要是验证规则没有的话就用regex
            'type_name' => 'required|unique:type|between:1,9',
        ],[
            // 自定义报错信息
            'type_name.required' =>'类型名称不能为空',
            'type_name.unique' =>'类型名称不能重复',
            'type_name.between' =>'类型名称在1~9之内',
            
        ]);
        // 判断是否有误有误的话就给报错提示
        if ($Validator->fails()) {
           return redirect('Type/index')
           // 报错默认
           ->with('data',$post)
           ->withErrors($Validator)
           ->withInput();
        }
        $ins = Type::insert($post);
        //判断是否添加到数据库
        if($ins){
            return redirect('Type/show');
        }
        
    }

    // ajax的的唯一性
    public function AjaxAdd(){
        // 接收值
        $type_name = request()->type_name;
        // 查询一个字段
        $count = Type::where('type_name',$type_name)->count();
        // 判断查询到的值是否大于零，大于零的话就是查询到了
        if($count>0){
            echo "on";
        }else{
            echo "ok";
        }
    }

    //列表页面
    public function show(){
        // 接收值
        $type_name = request()->type_name??'';
        // where条件
        $where = [];
        if($type_name){
            $where[] = ['type_name','like',"%$type_name%"];
        }
        //条件保留
        $query = request()->all();
        $data = Type::where($where)->paginate(10);
        // 统计个数
        foreach($data as $k=>$v){
            $data[$k]['attr_count'] = Attr::where('type_id','=',$v['type_id'])->count();
        }
        return view('admin.type.show',['date'=>$data,'query'=>$query]);
    }

}
