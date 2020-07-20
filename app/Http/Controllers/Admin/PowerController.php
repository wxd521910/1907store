<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Power; // 权限表
class PowerController extends Controller
{
    // 添加视图
    public function index(){
        // 查询权限表的所有数据
        $data = Power::get();
        // 调用无限极分类
        $getPower = CreatPower($data);
        return view('admin.power.index',['getPower'=>$getPower]);
    }

    // 执行添加
    public function add(){
        $data=request()->except('_token');
        $res=Power::create($data);
        // 判断是否添加到数据库
        if($res){
            return redirect('Power/show');
        }
    }

    // 权限展示页面
    public function show(){
        $powerInfo=Power::get();
        $powerInfo=getPowerInfo($powerInfo);
        return view('admin.power.show',['powerInfo'=>$powerInfo]);
    }

    // ajax验证唯一性
    public function ajaxsole(){
        // 接收值
        $power_name = request()->get('power_name');
        dump($power_name);die;
        // where条件查询
        $where[] = ['power_name','=',$power_name];
        // 查询一个字段
        $count = Power::where($where)->count();
        // 判断查询到的值是否大于零，大于零的话就是查询到了
        if($count>0){
            echo "on";
        }else{
            echo "ok";
        }
    }
}
