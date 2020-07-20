@extends('index.layouts_login.layouts')
@section('title', '登陆')
@section('content')
    <body>
    <div class="maincont">
        <header>
            <a href="javascript:history.back(-1)" class="back-off fl"><span
                        class="glyphicon glyphicon-menu-left"></span></a>
            <div class="head-mid">
                <h1>会员登陆</h1>
            </div>
        </header>
        <div class="head-top">
            <img src="/static/login/images/head.jpg"/>
        </div><!--head-top/ action="{{url('login/loginAdd')}}"   -->
        <form action="{{url('login/loginAdd')}}" method="post" class="reg-login">
            <h3>还没有微商城账号？点此<a class="orange" href="{{url('login/sign')}}">注册</a></h3>
            <div class="lrBox">
                <div class="lrList">
                    <input type="text" name="account" id="user_account" placeholder="输入手机号码或者邮箱号"/>
                    <!-- <input type="text" id="user_account" placeholder="输入手机号码或者邮箱号"/> -->
                </div>
                <div class="lrList">
                    <input type="password" name="pwd" id="user_pwd" placeholder="输入密码"/>
                    <!-- <input type="password" id="user_pwd" placeholder="输入密码"/> -->
                </div>
            </div><!--lrBox/-->
            <div class="lrSub">
                <input type="submit" id="btn" value="立即登录"/>
            </div>
        </form><!--reg-login/--> 
    </body>

    <script>
        // 页面加载
        // $(function(){
        //     // 点击登陆
        //     /**
        //      * 找到登陆按钮的id然后给一个点击事件
        //      * 要得到账号、密码、和记录十天
        //      */
        //     $("#btn").click(function(){
        //         // 账号、密码、记录十天
        //         var account = $("#user_account").val();
        //         var pwd = $("#user_pwd").val();
        //         var checkbox_me = $("#checkbox_me").prop('checked');
                
        //         // ajax传输值
        //         $.ajax({
        //             url:"{{url('login/loginAdd')}}",
        //             data:{account:account,pwd:pwd,checkbox_me:checkbox_me},
        //             type:'post',
        //             success:function(res){
        //                 // 打印
        //                 console.log(res);
        //             }
        //         })
        //     });
        // })

    </script>

@endsection

