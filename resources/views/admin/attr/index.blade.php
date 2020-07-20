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
<h3 align="center">属性页面</h3>
<form class="form-horizontal" role="form" action="{{url('Attr/add')}}" id="id_form" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">属性名称</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="attr_name"  value="{{session('data')['attr_name']}}" name="attr_name" placeholder="请输入类型名称">
            <!-- 自定义报错信息 -->
            <b style="color:red">{{$errors->first('attr_name')}}</b>
        </div>
    </div>
    <div class="form-group">
            <label for="firstname" class="col-sm-2 control-label">所属类型</label>
            <div class="col-sm-10">
                <select name="type_id" class="form-control" id="firstname">
                    <option value="0" selected >-请选择所属类型-</option>
                    @foreach ($getType as $v)
                        <option value="{{$v->type_id}}"> {{$v->type_name}} </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="firstname" class="col-sm-2 control-label">属性是否可选</label>
            <div class="col-sm-10">
                <label class="checkbox-inline">
                    <input type="radio" id="inlineCheckbox1" value="1" name="attr_type" checked>规格（可选）
                </label>
                <label class="checkbox-inline">
                    <input type="radio" id="inlineCheckbox1" value="2" name="attr_type">参数
                </label>
            </div>
        </div>
    
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">添加</button>
            <a href="{{url('Attr/show')}}" class="btn btn-info">列表展示</a>
        </div>
    </div>
</form>
</body>
</html>
