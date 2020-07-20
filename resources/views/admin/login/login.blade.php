<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>后台登陆系统</title>
    <meta name="author" content="DeathGhost"/>
    <link rel="stylesheet" type="text/css" href="/static/admin/css/styles.css" tppabs="/static/admin/css/styles.css"/>
    <script src="/static/admin/js/jquery.js"></script>
        <script src="/static/admin/js/verificationNumbers.js" tppabs="/static/admin/js/verificationNumbers.js"></script>
        <script src="/static/admin/js/Particleground.js" tppabs="/static/admin/js/Particleground.js"></script>
    <style>
        body {
            height: 100%;
            background: #16a085;
            overflow: hidden;
        }

        canvas {
            z-index: -1;
            position: absolute;
        }
    </style>
       
    <script>
        $(document).ready(function () {
            //粒子背景特效
            $('body').particleground({
                dotColor: '#5cbdaa',
                lineColor: '#5cbdaa'
            });
            //验证码
            createCode();
            //测试提交，对接程序删除即可
            $(".submit_btn").click(function () {
                location.href = "javascrpt:;"/*tpa=http://***index.html*/;
            });
        });
    </script>
</head>
<body>
  <form method="post" action="{{url('Login/add')}}">
    @csrf
      <dl class="admin_login">
          <dt>
              <strong>后台登陆管理系统</strong>
              <em>The Background of Landing</em>
              <em>{{session('erro')}}</em>
          </dt>
          <dd class="user_icon">
              <input type="text" name="admins_name" placeholder="请输入账号" class="login_txtbx"/>
          </dd>
          <dd class="pwd_icon">
              <input type="password" name="admins_pwd" placeholder="请输入密码" class="login_txtbx"/>
          </dd>
          <dd>
              <input type="submit" value="立即登陆" class="submit_btn"/>
          </dd>
          <dd>
              <p>你相信缘分吗？那是一种神秘又美丽的牵系。至于我们之间，我只想告诉你，我很珍惜。---张梦伟</p>
          </dd>
      </dl>
  </form>
</body>
</html>
