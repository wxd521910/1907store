
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
        <h3 align="center">类型数据展示</h3><hr/>
        <div align="center">
           <form action="" method="get">
                <input type="text" name="type_name"  placeholder="请输入类型名称" value="{{$query['type_name']??''}}">
                <input type="submit" value="搜索">
           </form>
        </div><hr/>
        @csrf
        <thead>
            <tr align="center">
                <td><b>类型ID</b></td>
                <td><b>类型名称</b></td>
                <td><b>属性数量</b></td>
                <td><b>操作</b></td>
            </tr>
            @foreach($date as $v)
                <tr align="center">
                    <td>{{$v->type_id}}</td>
                    <td>{{$v->type_name}}</td>
                    <td>{{$v->attr_count}}</td>
                    <td>
                        <a href="{{url('Attr/show'.'?'.'type_id'.'='.$v->type_id)}}" class="btn btn-success">查看属性</a>
                    </td>
                </tr>
            @endforeach
            <td colspan="5" align="center">
                {{$date->links()}}
            </td>
        </tbody>
    </table>
</body>
</html>
