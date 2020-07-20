<!-- 引入导航栏目 -->
@include('admin.public.bar')
<!-- 全局 -->
@include('admin.public.middle')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- <script src="/static/admin/js/jquery.min.js"></script> -->
    <script src="/static/admin/js/jquery.js"></script>
    <link rel="stylesheet" href="/static/admin/css/bootstrap.min.css">
</head>
<body>
<h3 align="center">管理员添加页面</h3>
<form class="form-horizontal" role="form" action="{{url('Admins/add')}}" id="id_form" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">用户名</label>
        <div class="col-sm-10">
            <input type="text" class="form-control"  name="admins_name" id="admins_name" value="{{session('data')['admins_name']}}" placeholder="请输入用户名">
            <!-- 自定义报错信息 -->
            <b style="color:red">{{$errors->first('admins_name')}}</b>
        </div>
    </div>
    <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">密码</label>
        <div class="col-sm-10">
            
            <input type="password" class="form-control"  name="admins_pwd" id="admins_pwd" value="{{session('data')['admins_pwd']}}" placeholder="请输入密码">
            <!-- 自定义报错信息 -->
            <b style="color:red">{{$errors->first('admins_pwd')}}</b>
        </div>
    </div>
    <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">性别</label>
        <div class="col-sm-10" >
            <input type="radio" name="admins_sex" value="1" >男
            <input type="radio" name="admins_sex" value="2" checked>女
        </div>
    </div>

    <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">所属角色</label>
        <div class="col-sm-10">
            <select name="parent_id" class="form-control" id="firstname">
                <option value="0" selected >请选择角色</option>
                @foreach ($roleInfo as $v)
                    <option value="{{$v->role_id}}">{{$v->role_name}} </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">管理员头像</label>
        <div class="col-sm-10" >
            <input type="file" name="admins_log" id="">
        </div>
    </div>
    <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">申请原因</label>
        <div class="col-sm-10">
            <textarea name="admins_content" rows="10px" cols="60px" id="admins_content" placeholder="请输入申请原因">{{session('data')['admins_content']}}</textarea>
            <!-- 自定义报错信息 -->
            <b style="color:red">{{$errors->first('admins_content')}}</b>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">添加</button>
        </div>
    </div>
</form>
</body>
    <script>
        // 页面刷新
        $(document).ready(function(){
            // 阻止提交
            $(document).on('submit','#id_form',function(){
                // 验证用户
                var res = name();
                if(res==false){
                    return false;
                }
                // 验证密码
                var pwds = pwd();
                if(pwds==false){
                    return false;
                }
                // 申请
                var contents = content();
                if(contents==false){
                    return false;
                }
                return true;
            });

            // 用户验证
            function name(){
                // 获取文本框的值
                var admins_name = $('#admins_name').val();
                // 分类名字的正则
                var reg =/^[\u4e00-\u9fa5\w.\-]{1,9}$/;
                // 验证非空
                if(admins_name==''){
                    alert('用户名不能为空');
                    return false;
                }else if(!reg.test(admins_name)){
                    alert('必须是汉字或者是数字下下划线组成1~9');
                    return false;
                }else{
                    var fala = false;
                    $.ajax({
                        method:'get',
                        url:"{{url('Admins/ajaxsole')}}",
                        data:{admins_name:admins_name},
                        async:false,
                    }).done(function(count){
                        if(count=='on'){
                            alert('分类名字已经存在');
                            fala = false;
                        }else{
                            fala = true;
                        }
                    });
                    return fala;
                }
            }

            // 密码
            function pwd(){
                // 获取值
                var admins_pwd = $('#admins_pwd').val();
                // 密码的正则
                var reg =/^[\u4e00-\u9fa5\w.\-]{6,15}$/;
                // 验证非空
                if(admins_pwd==''){
                    alert('密码不能为空');
                    return false;
                }else if(!reg.test(admins_pwd)){
                    alert('密码长度6~15位');
                    return false;
                }
            }

             // 申请
             function content(){
                // 获取值
                var admins_content = $('#admins_content').val();
                // 密码的正则
                var reg =/^[\u4e00-\u9fa5\w.\-]{10,200}$/;
                // 验证非空
                if(admins_content==''){
                    alert('申请不能为空');
                    return false;
                }else if(!reg.test(admins_content)){
                    alert('申请内容在10~200');
                    return false;
                }
            }
            
        })
    </script>
</html>