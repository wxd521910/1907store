
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
       
        <h3 align="center">权限数据展示</h3><hr/>
        @csrf
        <thead>
            <tr align="center">
                <td><b>ID</b></td>
                <td><b>权限名称</b></td>
                <td><b>权限路由</b></td>
                <td><b>操作</b></td>
            </tr>
            @foreach($powerInfo as $v)
                <tr align="center" p_id="{{$v->parent_id}}" class_id="{{$v->class_id}}">
                    <td>{{$v->power_id}}</td>
                    <td>{{str_repeat("|-",$v->level)}}{{$v->power_name}}</td>
                    <td>{{$v->url}}</td>
                    <td>
                        <a href="{{url('category/unp/'.$v->class_id)}}" class="btn btn-info">修改</a>
                        <a href="{{url('category/del/'.$v->class_id)}}" class="btn btn-danger">删除</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
 
</html>
