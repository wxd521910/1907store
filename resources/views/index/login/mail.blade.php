@extends('index.layouts_login.layouts')
@section('title', '邮箱注册')
@section('content')
    <body>
    <div class="maincont">
        <header>
            <a href="javascript:history.back(-1)" class="back-off fl">
              <span class="glyphicon glyphicon-menu-left"></span>
            </a>
            <div class="head-mid">
                <h1>会员注册</h1>
            </div>
        </header>
        <div class="head-top">
            <img src="/static/login/images/head.jpg"/>
        </div><!--head-top/-->
        <div class="head-top">
          <h3 >
            <a href="{{url('login/sign')}}" style="color:red">手机号注册</a>
          </h3>
        </div><!--head-top/-->
        <form action="{{url('login/mails')}}" method="post" class="reg-login">
            <h3>已经有账号了？点此<a class="orange" href="{{url('login/login')}}">登陆</a></h3>
            <div class="lrBox">
                <!-- <div class="lrList">
                  <input type="text" id="name" name="name" placeholder="输入用户名"/>
                </div> -->
                <div class="lrList">
                  <input type="text" id="email" name="email" placeholder="输入邮箱"/>
                </div>
                <!-- <div class="lrList">
                  <input type="text" id="mobile" name="mobile" placeholder="输入手机号"/>
                </div> -->
                <!-- <div class="lrList2">
                    <input type="text" name="code" placeholder="输入短信验证码"/>
                    <a id="send" class="btn btn-warning" style="transform:translateY(20%);/**下移元素**/" >获取验证码</a>
                </div> -->
                <div class="lrList">
                  <input type="password" name="pwd" placeholder="设置新密码（6-18位数字或字母）"/>
                </div>
                <div class="lrList">
                  <input type="password" name="pwds" placeholder="再次输入密码"/>
                </div>
            </div><!--lrBox/-->
            <div class="lrSub">
                <input type="submit" value="立即注册"/>
            </div>
        </form><!--reg-login/-->
        
    </div><!--maincont-->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    </body>
    <script>
      // ajax保护
      $.ajaxSetup({
        headers:{
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      })

      // 验证码
      // $("#send").click(function(){
      //   var mobile=$('#name').val();
      //     if(mobile==''){
      //       alert('用户名不可以为空');
      //       return;
      //     }
        
      //   var mobile=$('#mobile').val();
      //   var reg = /^1[3456789]\d{9}$/;
      //   if(mobile==''){
      //       alert('手机号不可以为空');
      //       return;
      //   }else if(!reg.test(mobile)){
      //       alert('手机号格式不正确');
      //       return;
      //   }

      //   var email=$('#email').val();
        
      //   var reg =  /^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*\.[a-zA-Z0-9]{2,6}$/
      //      if(!reg.test(email)){
      //       alert('邮箱格式不正确');
      //       return;
      //     }

      //     var mobile=$('#mobile').val();
      //     $('#send').text('60s');
      //     // setInterval：设定延时
      //     _t = setInterval(goTime,1000);
      //     $.ajax({
      //       method:"post",
      //       url:"{{url('login/sendAdd')}}",
      //       data:{mobile:mobile}
      //     }).done(function(res){
      //        console.log(res);
      //     })
      // })

      // 倒计时-->秒数
      // function goTime(){
      //   var second = $("#send").text();
      //   // parseInt() 函数可解析一个字符串，并返回一个整数。
      //   second = parseInt(second);
      //   if(second > 0){
      //       second = second-1;
      //       $("#send").text(second+'s');
      //       $("#send").css('pointer-events','none');
      //   }else{
      //       //清除定时器
      //       clearInterval(_t);
      //       $("#send").text('获取验证码');
      //       $("#send").css('pointer-events','auto');
      //   }
      // }

    </script>
@endsection