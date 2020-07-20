
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
                <input type="text" name="class_name"  placeholder="请输入分类名称" value="{{$query['class_name']??''}}">
                <input type="text" name="class_ant"  placeholder="请输入关键字" value="{{$query['class_ant']??''}}">
                <input type="submit" value="搜索">
           </form>
        </div><hr/>
        @csrf
       
        <thead>
            <tr align="center">
                <td><b>ID</b></td>
                <td><b>分类名称</b></td>
                <td><b>是否展示</b></td>
                <td><b>是否展示导航</b></td>
                <td><b>关键字</b></td>
                <td><b>分类描述</b></td>
                <td><b>操作</b></td>
            </tr>
            @foreach($data as $v)
                <tr align="center" p_id="{{$v->parent_id}}" class_id="{{$v->class_id}}">
                    <td>{{$v->class_id}}</td>
                    <td>
                        <b>
                            <a href="javascript:;" class="a_name">+</a>
                        </b>
                        {{str_repeat("|-",$v->level)}} {{$v->class_name}}
                    </td>
                    <td>@if($v->class_show==1) √ @else × @endif</td>
                    <td>@if($v->class_nav==1) √ @else × @endif</td>
                    <td>{{$v->class_ant}}</td>
                    <td>{{$v->class_desc}}</td>
                    <td>
                        <a href="{{url('category/unp/'.$v->class_id)}}" class="btn btn-info">修改</a>
                        <a href="{{url('category/del/'.$v->class_id)}}" class="btn btn-danger">删除</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
 <script>
        //吧p_id不等于零的给隐藏
        $("tr[p_id!='0']").hide();
        //点击符号，就是我们那个超链接的属性
        $(".a_name").click(function(){
            // 获取点击的超链接
            var _this = $(this);
            // 获取纯文本，对象.text();
            var sign = _this.text();
            // 获取祖先级的元素，当前获取自定义主键
            var class_id = _this.parents("tr").attr('class_id');
            // 判断当前的纯文本是否等于+号
            if(sign=="+"){
                // 区变量，获取自建，和副键
                var child = $("tr[p_id='"+class_id+"']");
                // 在判断里面判断，child.show;找到顶级下的分类进行显示
                if(child.length>0){
                    child.show();
                    _this.text("-");
                }
            }else{
                // 隐藏
                $("tr[p_id='"+class_id+"']").hide();
                _this.text('+');
            }
        })
    </script>
</html>
