<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <title>欢迎进入后台数据</title>
	<link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar navbar-default" role="navigation">
	<div class="container-fluid"> 
    <div class="navbar-header">
        <a class="navbar-brand" href="{{url('Admins/greet')}}">后台数据首页</a>
    </div>
    <div>
        <!--向左对齐-->
      
        <ul class="nav navbar-nav navbar-left">
            <li class="dropdown">
                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">管理员<b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="{{url('Admins/index')}}">管理员添加</a></li>
                    <li><a href="{{url('Admins/show')}}">管理员展示</a></li>
                </ul>
            </li>
        </ul>
        <ul class="nav navbar-nav navbar-left">
            <li class="dropdown">
                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">分类<b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="{{url('category/index')}}">分类添加</a></li>
                    <li><a href="{{url('category/show')}}">分类列表</a></li>
                </ul>
            </li>
        </ul>
        <ul class="nav navbar-nav navbar-left">
            <li class="dropdown">
                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">品牌<b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="{{url('Brand/index')}}">品牌添加</a></li>
                    <li><a href="{{url('Brand/show')}}">品牌列表</a></li>
                </ul>
            </li>
        </ul>
        <ul class="nav navbar-nav navbar-left">
            <li class="dropdown">
                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">商品<b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="{{url('Goods/index')}}">商品添加</a></li>
                    <li><a href="{{url('Goods/show')}}">商品列表</a></li>
                </ul>
            </li>
        </ul>
        <ul class="nav navbar-nav navbar-left">
            <li class="dropdown">
                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">类型<b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="{{url('Type/index')}}">类型添加</a></li>
                    <li><a href="{{url('Type/show')}}">类型列表</a></li>
                </ul>
            </li>
        </ul>
        <ul class="nav navbar-nav navbar-left">
            <li class="dropdown">
                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">属性<b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="{{url('Attr/index')}}">属性添加</a></li>
                    <li><a href="{{url('Attr/show')}}">属性列表</a></li>
                </ul>
            </li>
        </ul>
        <ul class="nav navbar-nav navbar-left">
            <li class="dropdown">
                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">权限<b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="{{url('Power/index')}}">权限添加</a></li>
                    <li><a href="{{url('Power/show')}}">权限列表</a></li>
                </ul>
            </li>
        </ul>
        <ul class="nav navbar-nav navbar-left">
            <li class="dropdown">
                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">角色<b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="{{url('Role/index')}}">角色添加</a></li>
                    <li><a href="{{url('Role/show')}}">角色展示</a></li>
                </ul>
            </li>
        </ul>
        <!--向右对齐-->
        <ul class="nav navbar-nav navbar-right">
           
            <div class="navbar-header">
                <a class="navbar-brand"style="font-size:15px">欢迎{{session('admin')['admins_name']}}登陆</a>
            </div>
            <div class="navbar-header">
                <a class="navbar-brand" href="{{url('Login/logout')}}" style="font-size:15px">退出</a>
            </div>
        </ul>
    </div>
	</div>
</nav>
</body>
</html>