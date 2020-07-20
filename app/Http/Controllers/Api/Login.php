<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ApiModel\Users;    //用户
use App\ApiModel\Auth; //验证
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use App\Tools\Sms;
use App\Exceptions\ApiException;

use Illuminate\Support\Facades\Cookie;
class Login extends Controller{

    // 注册接口
    public function regIster(){
        //接收值
        $name=request()->post('name');  //用户名
        $pwd=request()->post('pwd');  //密码
        $pwds=request()->post('pwds');  //重复密码
        $mobile=request()->post('mobile');  //手机号
        $email=request()->post('email');  //邮箱
        $code=request()->post('code');  //手机验证码
        // 数据校验
        
        $messages = [
            'name.required'=>'用户名必填',
            'name.unique'=>'用户名不能重复',
            'name.max'=>'用户名长度限制',
            'pwd.required'=>'密码必填',
            'pwds.same'=>'两次密码不一致',
            'mobile.required'=>'手机号不能为空',
            'mobile.unique'=>'手机号已注册',
            'mobile.regex'=>'手机号格式错误',
            'email.required'=>'邮箱重复',
            'email.unique'=>'邮箱已被注册',
            'email.email'=>'邮箱格式不正确',
            'code.required'=>'验证码不能为空',
        ];
        // 验证 regex:/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/'
        $Validator = Validator::make(request()->post(),[
            'name' => 'required|unique:users|max:12',
            'email'=>'required|unique:users|email:rfc',
            'mobile'=>'required|unique:users|regex:/^1[345789][0-9]{9}$/',
            'code'=>'required',
            'pwd'=>'required',
            'pwds'=>'same:pwd',
        ],$messages);
        // 判断是否有误有误的话就给报错提示
        if ($Validator->fails()){
            $msg = $Validator->errors()->first();
            throw (new ApiException)->SetErrorMessage($msg,'10001');
        }
        
        // 验证码判断
        $select = Auth::where('mobile','=',$mobile)->first();
        //验证验证码
        if($select['code'] != $code){
            // 有误
            throw (new ApiException)->SetErrorMessage('验证码输入有误','40003');
        }else if((time()>$select['time'])){
            // 失效
            throw (new ApiException)->SetErrorMessage('验证码失效','40004');
        }
        // 入库
        $user=Users::create([
                'name'=>$name,
                'pwd'=>md5($pwd),
                'mobile'=>$mobile,
                'email'=>$email,
                'time'=>time(),
            ]);
        if($user){
            return response()->json(['error'=>'200','msg'=>'ok']);
        }else{
            throw (new ApiException)->SetErrorMessage('Registration failed, please register again failure','40004');
        }
    }

    // 手机短信接口
    public function send(){
        // 接收手机号
        $mobile = request()->mobile;
        if(empty($mobile)){
            // 抛出异常
            throw (new ApiException)->SetErrorMessage('missing parameter','10001');
        }
        //验证码
        $code = rand(1000,9999);
        // 过期时间
        $time = time()+300;
        // 手机号重复验证码
        $first = Auth::where('mobile','=',$mobile)->update(['code'=>$code,'time'=>$time]);
        if($first>0){
            Sms::sendCode($mobile,$code);die;
        }
        // 数据入库
        $userCre = Auth::create([
            'code'=>$code,
            'mobile'=>$mobile,
            'time'=>$time,
        ]);
        if($userCre == false){
             // 抛出异常   入库失败
            throw (new ApiException)->SetErrorMessage('Warehousing come to nothing','40002');
        }
        // 调用手机发送短信
        $Sms = Sms::sendCode($mobile,$code);
        if($Sms){
            return response()->json(['error'=>'200','msg'=>'send successfully']);
        }else{
            // 抛出异常  失败
            throw (new ApiException)->SetErrorMessage('TemplateParam','40004');
        }
    }

    // 登陆接口
    public function loginDo(){
        $account=request()->post('account');    //手机号用户名和邮箱
        $pwd=trim(request()->post('pwd'));
        
        if(empty($pwd)){
            // 抛出异常  没有参数
            throw (new ApiException)->SetErrorMessage('密码或账号不能为空','40001');
        };
        if(empty($account)){
           // 抛出异常  没有参数
           throw (new ApiException)->SetErrorMessage('密码或账号不能为空','40001');
        };
		//查询账号
        $userInfo=Users::Where('name',$account)->orWhere('mobile',$account)->first();
        $user_id = $userInfo['id'];
        //生成令牌
        $userToken=md5($account.$pwd).time().rand(100000,999999);
        // 使用时间
        $userTokenExpire = time()+7200;
        // 入库  s
        $user=Users::where('mobile',$account)->orwhere('name',$account)->update(['userToken'=>$userToken,'userTokenExpire'=>$userTokenExpire,'is_login'=>1]);
        if($user==false){
            // 抛出异常 
            throw (new ApiException)->SetErrorMessage('用户不存在请核对后登陆','40002');
        }
        if(!$userInfo){
            // 抛出异常  不存在
            throw (new ApiException)->SetErrorMessage('用户不存在请核对后登陆','40002');
        }else if(md5($pwd)!==$userInfo['pwd']){
            // 抛出异常  密码错误
            $this->tmie($account,$userInfo);
            throw (new ApiException)->SetErrorMessage('密码或账号错误','40002');
        }else{
            return response()->json([
                'error'=>'200',
                'msg'=>'ok',
                'data'=>[
                    'userToken'=>$userToken,
                    'userTokenExpire'=>$userTokenExpire,
                    'account'=>$account,
                    'user_id'=>$user_id,
                ]
            ]);
        }
    }
    
    // 错误三次锁定一小时 account接收的用户名，userInfo查询一条的数据
    public function tmie($account,$userInfo){
        /**
         * 
        */
        // 判断次数是否大于五次，不是的话次数修改值加一，如果是的话报错，如果大于五次了病超过的相对于的时间就把次数清空
        if($userInfo['errey_limit']>=5){

            if((time() - $userInfo['errey_thim']) > 10){
                Users::where('name',$account)->update(['errey_limit'=>1,'errey_thim'=>null]);
            }

            throw (new ApiException)->SetErrorMessage('频繁操作，请五分钟后重试','40002');die;
        }else{
            Users::where('name',$account)->update(['errey_limit'=>$userInfo['errey_limit']+1,'errey_thim'=>time()]);
           
        }
        
        
        
    }

}

