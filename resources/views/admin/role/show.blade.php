
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
    <title>角色展示</title>
</head>
<body>
    <table class="table">
       
        <h3 align="center">后台数据展示</h3><hr/>
        
        </div><hr/>
        @csrf
       
        <thead>
            <tr align="center">
                <td><b>ID</b></td>
                <td><b>角色名称</b></td>
                <td><b>角色权限</b></td>
                <td><b>操作</b></td>
            </tr>
            @foreach($roleInfo as $v)
                <tr align="center">
                    <td>{{$v['role_id']}}</td>
                    <td>{{$v['role_name']}}</td>
                    <td  width="750">
                        @foreach ($v['power'] as $vv)
                            {{$vv['power_name']}} —— 
                        @endforeach
                    </td>
                    <td>
                        <a href="{{url('category/unp/'.$v['role_id'])}}" class="btn btn-info">修改</a>
                        <a href="{{url('category/del/'.$v['role_id'])}}" class="btn btn-danger">删除</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
