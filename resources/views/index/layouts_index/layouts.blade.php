<!DOCTYPE html>
<html>

	<head>
        <base href="/static/index/">
		<meta charset="utf-8">
		<title>@yield('title')</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">

		<!--标准mui.css-->
		<link rel="stylesheet" href="css/mui.min.css">
		<!--App自定义的css-->
		<link rel="stylesheet" type="text/css" href="css/app.css"/>
		<link rel="stylesheet" type="text/css" href="css/icons-extra.css">
		<!--自定义iconfont-->
        <link rel="stylesheet" type="text/css" href="css/iconfont.css">
        <script src="js/mui.min.js"></script>
		<script src="js/jquery.min.js"></script>
		<!-- 商品详情 -->
		<link rel="stylesheet" type="text/css" href="css/pro2.css">
		<!-- 分类 -->
		<style>
			.item {
				display: none;
			}
			
			.show {
				display: block;
			}
			.current{color: #f60;}
		</style>
	</head>

	<body style="background: #fff;">

        <div class='container' style='margin-top:5%'>
                @yield('content')
        </div>
	
	</body>

</html>

