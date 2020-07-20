
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
        <h3 align="center">属性数据展示</h3><hr/>
        <div align="center">
            <form class="form-inline"  method="get">
                    <select name="type_id" id="firstname" >
                        <option value="0" selected >-查询所有-</option>
                        @foreach($dataType as $v)
                            <option value="{{$v->type_id}}" {{request()->type_id == $v->type_id?'selected':''}}> {{$v->type_name}} </option>
                        @endforeach
                    </select>
                <input type="submit"  value="搜索">
            </form>
        </div><hr/>
        @csrf
        <thead>
            <tr align="center">
                <td><b>属性ID</b></td>
                <td><b>属性名称</b></td>
                <td><b>所属类型</b></td>
                <td><b>是否可选</b></td>
                <td><b>操作</b></td>
            </tr>
            @foreach($data as $v)
                <tr align="center">
                    <td>{{$v->attr_id}}</td>
                    <td>{{$v->attr_name}}</td>
                    <td>{{$v->type_name}}</td>
                    <td>@if($v->attr_type==1) 是 @else 否 @endif</td>
                    <td>
                        <a href="" class="btn btn-info">修改</a>
                        <a href="" class="btn btn-info">删除</a>
                    </td>
                </tr>
            @endforeach
            <td colspan="5" align="center">
                {{$data->links()}}
            </td>
        </tbody>
    </table>
</body>
</html>
