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
<h3 align="center">品牌添加页面</h3>
<form class="form-horizontal" role="form" action="{{url('Brand/add')}}" id="id_form" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">品牌名称</label>
        <div class="col-sm-10">
            <input type="text" class="form-control"  name="brand_name" id="brand_name" value="{{session('data')['brand_name']}}" placeholder="请输入品牌名称">
            <!-- 自定义报错信息 -->
            <b style="color:red">{{$errors->first('brand_name')}}</b>
        </div>
    </div>
    <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">品牌网址</label>
        <div class="col-sm-10">
            
            <input type="text" class="form-control"  name="brand_url" id="brand_url" value="{{session('data')['brand_url']}}" placeholder="请输入品牌网址">
            <!-- 自定义报错信息 -->
            <b style="color:red">{{$errors->first('brand_url')}}</b>
        </div>
    </div>
    <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">品牌log</label>
        <div class="col-sm-10" >
            <input type="file" name="brand_log" id="">
        </div>
    </div>
    <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">品牌介绍</label>
        <div class="col-sm-10">
            <textarea name="brand_intr" rows="10px" cols="60px" id="brand_intr" placeholder="请输入品牌介绍">{{session('data')['brand_intr']}}</textarea>
            <!-- 自定义报错信息 -->
            <b style="color:red">{{$errors->first('brand_intr')}}</b>
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
        // 阻止提交
        $(document).ready(function(){
            // 阻止提交
            $(document).on('submit','#id_form',function(){
                // 验证用户
                var res = name();
                if(res==false){
                    return false;
                }
                // 验证网址
                var urls = url();
                if(urls==false){
                    return false;
                }
                // 验证网址
                var intrs = intr();
                if(intrs==false){
                    return false;
                }
               
                return true;
            });

             // 用户验证
             function name(){
                // 获取文本框的值
                var brand_name = $('#brand_name').val();
                // 分类名字的正则
                var reg =/^[\u4e00-\u9fa5\w.\-]{1,9}$/;
                // 验证非空
                if(brand_name==''){
                    alert('品牌名不能为空');
                    return false;
                }else if(!reg.test(brand_name)){
                    alert('必须是汉字或者是数字下下划线组成1~9');
                    return false;
                }else{
                    var fala = false;
                    $.ajax({
                        method:'get',
                        url:"{{url('Brand/ajaxsole')}}",
                        data:{brand_name:brand_name},
                        async:false,
                    }).done(function(count){
                        if(count=='on'){
                            alert('品牌名称已经存在');
                            fala = false;
                        }else{
                            fala = true;
                        }
                    });
                    return fala;
                }
            }

            // 网址
            function url(){
                // 获取文本框的值
                var brand_url = $('#brand_url').val();
                // 验证非空
                if(brand_url==''){
                    alert('网址不能为空');
                    return false;
                }else{
                    var fala = false;
                    $.ajax({
                        method:'get',
                        url:"{{url('Brand/ajaxsole')}}",
                        data:{brand_url:brand_url},
                        async:false,
                    }).done(function(count){
                        if(count=='on'){
                            alert('网址已经存在');
                            fala = false;
                        }else{
                            fala = true;
                        }
                    });
                    return fala;
                }
            }

             // 品牌详情
             function intr(){
                // 获取文本框的值
                var brand_intr = $('#brand_intr').val();
                // 分类名字的正则
                var reg =/^[\u4e00-\u9fa5\w.\-]{5,50}$/;
                // 验证非空
                if(brand_intr==''){
                    alert('品牌详情不能为空');
                    return false;
                }else if(!reg.test(brand_intr)){
                    alert('品牌详情在5~50');
                    return false;
                }
            }
        });
    </script>
</html>