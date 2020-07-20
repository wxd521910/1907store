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
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
<h3 align="center">添加角色</h3>
<form class="form-horizontal" role="form" action="{{url('Role/add')}}" id="id_form" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">角色名称</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="role_name" name="role_name" placeholder="请输入角色名称">
            <!-- 自定义报错信息 -->
            <!-- <b style="color:red">{{$errors->first('class_name')}}</b> -->
        </div>
    </div>
   
    <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">所属权限</label>
        <div class="col-sm-10">
            <table>
                @foreach ($powerInfo as $v)
                    <tr>
                        <td>
                            <input type="checkbox" class="box" value="{{$v['power_id']}}" name="power_id[]">{{$v['power_name']}}&nbsp;&nbsp;&nbsp;
                        </td>
                        @foreach($v['child'] as $vv)
                        <td>
                            <input type="checkbox" class="power" value="{{$vv['power_id']}}" name="power_id[]">{{$vv['power_name']}}&nbsp;&nbsp;&nbsp;
                        </td>
                        @endforeach
                    </tr>
                @endforeach
            </table>
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
    // 页面刷新
    $(document).ready(function(){
        //权限全选
        $('.box').on('click',function(){
          var _this=$(this);
          var status=_this.prop('checked');
          _this.parent().nextAll().find('.power').prop('checked',status);
        })
      
    })
</script>
</html>