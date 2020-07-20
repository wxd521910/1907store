
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
                <td><b>品牌名称</b></td>
                <td><b>品牌网址</b></td>
                <td><b>品牌log</b></td>
                <td><b>添加时间</b></td>
                <td><b>修改时间</b></td>
                <td><b>品牌详情</b></td>
                <td><b>操作</b></td>
            </tr>
            @foreach($get as $v)
                <tr align="center" id="{{$v->brand_id}}">
                    <td>{{$v->brand_id}}</td>
                    <td find="brand_name">
                        <span class="span_name">{{$v->brand_name}}</span>
                        <input type="text" style="display:none" class="input_name" value="{{$v->brand_name}}">
                    </td>
                    <td>{{$v->brand_url}}</td>
                    <td>
                        <img src="/{{$v->brand_log}}" alt="" while="20px" height="40px">
                    </td>
                    <td>{{$v->brand_thim}}</td>
                    <td>{{$v->brand_thims}}</td>
                    <td>{{$v->brand_intr}}</td>
                    <td>
                        <a href="{{url('Brand/unp/'.$v->brand_id)}}" class="btn btn-info">修改</a>
                        <a href="{{url('Brand/del/'.$v->brand_id)}}" class="btn btn-danger">删除</a>
                    </td>
                </tr>
            @endforeach
            <td colspan="12" align="center">
                {{$get->appends($query??'')->links()}}
            </td>
        </tbody>
    </table>
</body>
    <script>
         // 页面刷新
    $(document).ready(function(){
        // 点击
        $(document).on('click','.span_name',function(){
            var _this = $(this);
            _this.hide();
            _this.next("input").show().focus();
        })
        // 失去
        $(document).on('blur','.input_name',function(){
            var _this = $(this);
           
            var _value = _this.val();
            
            var _find = _this.parent().attr('find');
            
            var _id = _this.parents('tr').attr('id');
            $.get(
                "{{url('Brand/ajaxunp')}}",
                {_value:_value , _find:_find , _id:_id},
                function(pards){
                    if(pards=="onok"){
                        alert('修改成功');
                        _this.hide();
                        _this.prev('span').text(_value).show();
                    }else if(pards=="okno"){
                        alert('修改数据重复，或者是未修改');
                        history.go(0);
                    }else{
                        alert('修改失败');
                        history.go(0);
                    }
                   
                }
            );
        })
    });
    </script>
</html>
