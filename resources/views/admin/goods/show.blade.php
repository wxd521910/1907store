
<!-- 引入导航栏目 -->
@include('admin.public.bar')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/static/admin/css/bootstrap.min.css">  
    <script src="/static/admin/js/jquery.js"></script>
	<!-- <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script> -->
	<!-- <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
    <title>后台数据展示</title>
</head>
<body>
    <table class="table">
        <h3 align="center">后台数据展示</h3><hr/>
        <div align="center">
           <form action="" method="get">
                <input type="text" name="brand_name"  placeholder="请输入品牌名称" value="{{$query['brand_name']??''}}">
                <input type="submit" value="搜索">
           </form>
        </div><hr/>
        @csrf
       
        <thead>
            <tr align="center">
                <td><b>ID</b></td>
                <td><b>商品名称</b></td>
                <td><b>商品分类</b></td>
                <td><b>品牌</b></td>
                <td><b>商品图片</b></td>
                <td><b>商品相册</b></td>
                <td><b>商品价格</b></td>
                <td><b>商品是否上线</b></td>
                <td><b>商品添加时间</b></td>
                <!-- <td><b>商品修改时间</b></td> -->
                <!-- <td><b>商品库存</b></td> -->
                <td><b>商品货号</b></td>
                <!-- <td><b>生产地</b></td> -->
                <td><b>商品详情</b></td>
                <td><b>操作</b></td>
            </tr>
            @foreach($get as $v)
                <tr align="center">
                    <td>{{$v->goods_id}}</td>
                    <td>{{$v->goods_name}}</td>
                    <td>{{$v->class_name}}</td>
                    <td>{{$v->brand_name}}</td>
                    <td>
                        <img src="/{{$v->goods_log}}" alt="" while="20px" height="40px">
                    </td>
                    <td>
                        @if($v->goods_logs)
                            @foreach ($v->goods_logs as $vv)
                                <img src="/{{$vv}}" alt="" while="20px" height="40px">
                            @endforeach
                        @endif
                    </td>
                    <td>{{$v->goods_price}}</td>
                    <td>@if($v->goods_pop==1) √ @else × @endif</td>
                    <td>{{$v->goods_thim}}</td>
                    <!-- <td>{{$v->goods_thims}}</td> -->
                    <!-- <td>{{$v->goods_reper}}</td> -->
                    <td>{{$v->goods_ltem}}</td>
                    <!-- <td>{{$v->sheng}}{{$v->shi}}{{$v->qu}}</td> -->
                    <td>{{$v->goods_intr}}</td>
                    <td>
                        <a href="{{url('Brand/unp/'.$v->brand_id)}}" class="btn btn-info">修改</a>
                        <a href="{{url('Brand/del/'.$v->brand_id)}}" class="btn btn-danger">删除</a>
                    </td>
                </tr>
            @endforeach
            <td colspan="18" align="center">
                {{$get->links()}}
            </td>
        </tbody>
    </table>
</body>
</html>
