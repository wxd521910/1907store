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
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
<h3 align="center">分类添加页面</h3>
<form class="form-horizontal" role="form" action="{{url('category/add')}}" id="id_form" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">分类名称</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="class_name"  value="{{session('data')['class_name']}}" name="class_name" placeholder="请输入分类名称">
            <!-- 自定义报错信息 -->
            <b style="color:red">{{$errors->first('class_name')}}</b>
        </div>
    </div>
    <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">关键字</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="class_ant" value="{{session('data')['class_ant']}}" name="class_ant" placeholder="请输入关键字">
            <!-- 自定义报错信息 -->
            <b style="color:red">{{$errors->first('class_ant')}}</b>
        </div>
    </div>
    <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">请选择商品分类</label>
        <div class="col-sm-10">
            <select name="parent_id" class="form-control" id="firstname">
                <option value="0" selected >默认为顶级分类</option>
                @foreach ($getclass as $v)
                    <option value="{{$v->class_id}}"> {{str_repeat("|-",$v->level)}} {{$v->class_name}} </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">是否上线</label>
        <div class="col-sm-10" >
            <input type="radio" name="class_show" value="1" >是
            <input type="radio" name="class_show" value="2" checked>否
        </div>
    </div>
    <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">是否展示导航栏</label>
        <div class="col-sm-10">
            <input type="radio" name="class_nav" value="1">是
            <input type="radio" name="class_nav" value="2" checked>否
        </div>
    </div>
    <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">分类描述</label>
        <div class="col-sm-10">
            <textarea name="class_desc" id="class_desc" rows="10px" cols="60px" placeholder="请输入分类描述" >{{session('data')['class_desc']}}</textarea>
            <!-- 自定义报错信息 -->
            <b style="color:red">{{$errors->first('class_desc')}}</b>
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
        // 表单阻止提交
        $(document).on('submit','#id_form',function(){
            // 引用名字的方法
            var res = name();
            if(res==false){
                return false;
            }

            // 关键字
            var guanjian = ant();
            if(guanjian==false){
                return false;
            }

            // 分类描述
            var guanjian = desc();
            if(guanjian==false){
                return false;
            }

            return true;
        });
        // 验证分类名称
        function name(){
            // 获取文本框的值
            var class_name =$('#class_name').val();
            // 分类名字的正则
            var reg =/^[\u4e00-\u9fa5\w.\-]{1,9}$/;
            // 判断是否为空
            if(class_name==''){
                alert('分类名称不能为空');
                return false;
            }else if(!reg.test(class_name)){
                alert('必须是汉字或者是数字下下划线组成1~9');
                return false;
            }else{
                // return返回不了的东西，在Ajax的验证唯一性中 (1)
                var falg = false;
                // 把账号传输给控制器                        (2)
                $.ajax({
                    method:'get', // 提交方式
                    url:"{{url('category/ajaxsole')}}", // 提交地址
                    data:{class_name:class_name}, // 提交数据
                    async:false, // 同步，async默认就是异步
                }).done(function(count){
                    if(count=='on'){
                        alert('分类名称已经存在');
                        falg = false;
                    }else{
                        falg = true;
                    }
                })
                // 返回值
                return falg;
            }


        }
        // 关键字
        function ant(){
            // 获取文本框的值
            var class_ant =$('#class_ant').val();
            // 判断是否为空
            if(class_ant==''){
                alert('关键字不能为空');
                return false;
            }
        }
        
        // 分类描述
        function desc(){
            // 获取文本框的值
            var class_desc =$('#class_desc').val();
            // 分类名字的正则
            var reg =/^[\u4e00-\u9fa5\w.\-]{3,50}$/;
            // 判断是否为空
            if(class_desc==''){
                alert('分类描述不能为空');
                return false;
            }else if(!reg.test(class_desc)){
                alert('分类描述在3~50字内');
                return false;
            }
        }
    })
</script>
</html>