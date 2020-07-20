<!-- 全局 -->
@include('admin.public.middle')
<!-- 引入导航栏目 -->
@include('admin.public.bar')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="/static/admin/js/jquery.min.js"></script>
    <script src="/static/admin/js/jquery.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
<h3 align="center">类型页面</h3>
<form class="form-horizontal" role="form" action="{{url('Type/add')}}" id="id_form" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">类型名称</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="type_name"  value="{{session('data')['type_name']}}" name="type_name" placeholder="请输入类型名称">
            <!-- 自定义报错信息 -->
            <b style="color:red">{{$errors->first('type_name')}}</b>
        </div>
    </div>
    
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">添加</button>
        <a href="{{url('Type/show')}}" class="btn btn-info">列表展示</a>
           
        </div>
    </div>
</form>
</body>
<script>
    // ajax保护
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    // 页面刷新
    $(document).ready(function(){
        // 表单阻止提交
        $(document).on('submit','#id_form',function(){
            // 引用名字的方法
            var res = name();
            if(res==false){
                return false;
            }
            return true;
        });

        // 验证分类名称
        function name(){
            // 获取文本框的值
            var type_name =$('#type_name').val();
            // 分类名字的正则
            var reg =/^[\u4e00-\u9fa5\w.\-]{1,9}$/;
            // 判断是否为空
            if(type_name==''){
                alert('类型名称不能为空');
                return false;
            }else if(!reg.test(type_name)){
                alert('必须是汉字或者是数字下下划线组成1~9');
                return false;
            }else{
                // return返回不了的东西，在Ajax的验证唯一性中 (1)
                var falg = false;
                // 把账号传输给控制器                        (2)
                $.ajax({
                    method:'post', // 提交方式
                    url:"{{url('Type/AjaxAdd')}}", // 提交地址
                    data:{type_name:type_name}, // 提交数据
                    async:false, // 同步，async默认就是异步
                }).done(function(count){
                    if(count=='on'){
                        alert('类型名称已经存在');
                        falg = false;
                    }else{
                        falg = true;
                    }
                })
                // 返回值
                return falg;
            }


        }
     
    });
</script>
</html>
