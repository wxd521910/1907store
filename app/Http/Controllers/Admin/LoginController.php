<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Admins;  // 实例化一个登陆表
use App\Model\RolePower;  // 权限角色
// 缓存的门面
use Illuminate\Support\Facades\Cache;
class LoginController extends Controller{

    // 登陆视图
    function index(){
        return view('admin\login\login');
    }

    // 执行登陆
    function add(){
        $_token = request()->except('_token');
        $admins_name = $_token['admins_name'];
        $admins_pwd = md5($_token['admins_pwd']);
       
        // 给一个where数组光接收用户名
        $where = [
            ['admins_name','=',$admins_name],
            ['admins_pwd','=',$admins_pwd]
        ];
        // 查询数据库
        $admin = Admins::where($where)->first();
        if($admin==false){
            // echo "<script>alert('缺少参数');location.href='/Admin/login'</script>";die;
             return redirect('/Admin/login')->with('erro','账号或密码有误');die;
        }
        $roleWhere = [
            ['role_id','=',$admin['role_id']],
        ];
        $power=RolePower::join('power','role_power.power_id','=','power.power_id')
                            ->where($roleWhere)
                            ->get()
                            ->toArray();
        $admin['power']=$power;
        if($admin){
            // 存入session
            session(['admin'=>$admin]);
            request()->session()->save();
            return redirect('Admins/greet');
        }else{
            // return redirect('Login/index')->with('erro','登陆失败');
            echo "<script>alert('登陆失败');location.href='/Admin/login'</script>";
        }
    }

    // 登陆退出
    function logout(){
        // 清除session
        session(['admin'=>null]);
        request()->session()->save();
        echo "<script>alert('退出成功');location.href='/Admin/login'</script>";
        // return view('admin/login/login');
    }


   
}
