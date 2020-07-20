<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Admins;  // 实例化管理员表
use App\Model\Role;   //角色表
// 验证器
use Validator;
class AdminsController extends Controller{
    // 管理员添加视图
    function index(){
        $roleInfo=Role::get();
        return view('admin.admins.index',['roleInfo'=>$roleInfo]);
        // return view('admin.admins.index');
    }

    // 后台登陆首页
    function greet(){
       
        return view('admin.admins.greet');
    }

    // 添加
    function add(){
        // 接收值
        $post = request()->except('_token');
        // 验证器
        $validator = Validator::make($post, [
            'admins_name' => 'required|unique:admins|between:2,15',
            'admins_pwd' => 'required|between:6,32',
            'admins_content' => 'required|between:10,200',
        ],[
            'admins_name.required' => '管理员名称不能为空',
            'admins_name.unique' => '管理员名称已重复',
            'admins_name.between' => '管理员名称在2~15位之间',
            'admins_pwd.required' => '密码不能为空',
            'admins_pwd.between' => '密码在6~15位',
            'admins_content.required' => '申请不能为空',
            'admins_content.between' => '申请在10~200位之间',
        ]);
        
         // 报错默认
        if ($validator->fails()) {
            unset($post['admins_log']);
                return redirect('Admins/index')
                ->with('data',$post)
                ->withErrors($validator)
                ->withInput();
        }
        // md5加密
        $admins_pwd = md5($post['admins_pwd']);
        if(!empty($admins_pwd)){
            $post['admins_pwd']=$admins_pwd;
        }
        //时间 
        $post['admins_thim'] = date('Y-m-d h:i:s',time());
        // 文件上传，hasFile判断文件在请求中是否存在
        if(request()->hasFile('admins_log')){
            // echo 123;die;
            $post['admins_log']=unifile('admins_log');
        }
        $ins = Admins::insert($post);
        //判断是否添加到数据库
        if($ins){
            return redirect('Admins.show');
        }
        
    }

    // ajax验证唯一性
    function ajaxsole(){
        $admins_name = request()->get('admins_name');
        $where[] = ['admins_name','=',$admins_name];
        $count = Admins::where($where)->count();
        if($count>0){
            echo "on";
        }else{
            echo "ok";
        }
    }

    // 列表展示
    function show(){
        // 接收值
        $admins_name = request()->admins_name??'';
        
        // where条件
        $where = [];
        if($admins_name){
            $where[] = ['admins_name','like',"%$admins_name%"];
        }
      
        //条件保留
        $query = request()->all();
        $get = Admins::where($where)->paginate(20);
        return view('admin.admins.show',['get'=>$get,'query'=>$query]);
    }

    // 删除
    function del($id){
        $dels = Admins::where('admins_id',$id)->delete();
        if($dels){
            return redirect('Admins/show');
        }
    }

    // 修改页面
    function unp($id){
        //查询数据，进行数据返回 
        $firsts = Admins::where('Admins_id',$id)->first();
        return view('admin.admins.unp',['firsts'=>$firsts]);
    }

    // 执行修改
    function unps($id){
        // 接收值
        $post = request()->except('_token');
        // 验证器
        $validator = Validator::make($post, [
            'admins_name' => 'required|between:2,15',
            'admins_pwd' => 'required|between:6,32',
            'admins_content' => 'required|between:10,200',
        ],[
            'admins_name.required' => '管理员名称不能为空',
            
            'admins_name.between' => '管理员名称在2~15位之间',
            'admins_pwd.required' => '密码不能为空',
            'admins_pwd.between' => '密码在6~15位',
            'admins_content.required' => '申请不能为空',
            'admins_content.between' => '申请在10~200位之间',
        ]);
        
         // 报错默认
        if ($validator->fails()) {
            unset($post['admins_log']);
                return redirect('Admins/index')
                ->with('data',$post)
                ->withErrors($validator)
                ->withInput();
        }
        // md5加密
        $admins_pwd = md5($post['admins_pwd']);
        if(!empty($admins_pwd)){
            $post['admins_pwd']=$admins_pwd;
        }
        //时间 
        $post['admins_thims'] = date('Y-m-d h:i:s',time());
        // 文件上传，hasFile判断文件在请求中是否存在
        if(request()->hasFile('admins_log')){
            // echo 123;die;
            $post['admins_log']=unifile('admins_log');
        }
        //添加到数据库
        $ins = Admins::where('admins_id',$id)->update($post);
        //判断并跳转
        if($ins!==false){
            return redirect('Admins.show');
        }
    }

    // 及点击该
    function ajaxunp(){
        // 接收值
        $value = request()->get('_value');
        $find = request()->get('_find');
        $id = request()->get('_id');
        // 验证重复
        $wheres[]= ['admins_name','=',$value];
        $cren =  Admins::where($wheres)->count();
        if($cren==false){
            echo "on";
        }else{
            echo "ok";
        }
        $where[] = ['admins_id','=',$id];
        $arr = [$find=>$value];
        $pards = Admins::where($where)->update($arr);
        if($pards==false){
            echo "no";
        }else{
            echo "ok";
        }
    }
}
