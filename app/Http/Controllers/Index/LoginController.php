<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ApiModel\Users;

use Illuminate\Support\Facades\Redis;
// 邮箱类
use Mail;
class LoginController extends Controller{
    // 注册页面
    public function sign(){
        return view('index.login.reg');
    }

    // // 邮箱注册
    // public function mail(){
    //     return view('index.login.mail');
    // }

    // 邮箱注册
    // public function mails(){
    //     $data = request()->email;
    //     $res = ['email'=>$data];
    //      Mail::send('index.emails.test',['data'=>$data],function($message)
    //     {
    //           $to = '123456789@qq.com';
    //           $message ->to($to)->subject('测试邮件');
    //      });
       
    // }

    // 执行注册
    public function SignAdd(){
        $data=request()->all();
        // 接口
        $url = env('INDEX.URL').'api/Index/regIster';
        // 调用接口
        $res=curl($url,'post',$data);
        // 返回json
        $res=json_decode($res,true);
        
        // 错误返回
        $msg=$res['msg'];
        
        if($res['error']==200){
            echo "<script>alert('注册成功');location.href='login'</script>";
        }else{
            echo "<script>alert('.$msg.');location.href='sign'</script>";
        }
    }

    // 手机短信
    public function sendAdd(){
        $data=request()->all();
        // 接口
        $url = env('INDEX.URL').'api/Index/send';
        // 调用接口
        $res=curl($url,'post',$data);
        // 返回json
        $res=json_decode($res,true);
        // 错误返回
        $msg=$res['msg'];
        if($res['error']==200){
            echo "<script>alert('发送成功');</script>";
        }else{
            echo "<script>alert('.$msg.');location.href='sign'</script>";
        }
    }

    // 登陆视图
    public function login(){
        return view('index.login.login');
    }

    // 执行登陆
    public function loginAdd(){
        $data=request()->all();
        $url=env('INDEX.URL')."api/Index/loginDo";
        $res=curl($url,'post',$data);
        $res=json_decode($res,true);
        // $userList=[
        //         'user_id' =>$res['data']['user_id'],
        //         'account' =>$res['data']['account'],
        //         'userToken' =>$res['data']['userToken'],
        // ];
        // 错误返回
        $msg=$res['msg'];
       
        if($res['error']==200){
            // echo "成功";
            session(['userList'=>$res['data']]);
            echo "<script>alert('登陆成功');location.href='/'</script>";
        }else{
            echo "<script>alert('.$msg.');location.href='login'</script>";
        }
    }

   

}
