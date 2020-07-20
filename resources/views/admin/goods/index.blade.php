<!-- 全局 -->

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
<h3 align="center">商品添加页面</h3>

<form class="form-horizontal" role="form" action="{{url('Goods/add')}}" id="id_form" method="post" enctype="multipart/form-data">
    <ul id="myTab" class="nav nav-tabs">
        <li class="active">
            <a href="#home" data-toggle="tab">商品添加</a>
        </li>
        <li>
            <a href="#ios" data-toggle="tab">商品属性</a>
        </li>

        <li>
            <a href="#date" data-toggle="tab">商品详情</a>
        </li>
    </ul>
    <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade in active" id="home">
            <p>
            @csrf
            <div class="form-group">
                <label for="firstname" class="col-sm-2 control-label">商品名称</label>

                <div class="col-sm-10">
                    <input type="text" class="form-control" id="goods_name" value="{{session('data')['goods_name']}}" name="goods_name" placeholder="请输入商品名称">
                    <!-- 自定义报错信息 -->
                    <b style="color:red">{{$errors->first('goods_name')}}</b>
                </div>
            </div>
            <div class="form-group">
                <label for="firstname" class="col-sm-2 control-label">商品价格</label>

                <div class="col-sm-10">
                    <input type="text" class="form-control" id="goods_price" value="{{session('data')['goods_price']}}" name="goods_price" placeholder="请输入商品价格">
                    <!-- 自定义报错信息 -->
                    <b style="color:red">{{$errors->first('goods_price')}}</b>
                </div>
            </div>
       
            <div class="form-group">
                <label for="firstname" class="col-sm-2 control-label">品牌</label>

                <div class="col-sm-10">
                    <select name="brand_id" class="form-control" id="firstname">
                        <option value="0" selected>请选择品牌</option>
                        @foreach ($brands as $v)
                            <option value="{{$v->brand_id}}"> {{$v->brand_name}} </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="firstname" class="col-sm-2 control-label">请选择商品分类</label>

                <div class="col-sm-10">
                    <select name="class_id" class="form-control" id="firstname">
                        <option value="0" selected>请选择商品分类</option>
                        @foreach ($getclass as $v)
                            <option value="{{$v->class_id}}"> {{str_repeat("|-",$v->level)}} {{$v->class_name}} </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <!-- <div class="form-group">
                <label for="firstname" class="col-sm-2 control-label">出生产地</label>

                <div class="col-sm-10">
                    <select name="sheng" id="">
                        <option value="">请选择</option>
                        @foreach($Areas as $v)
                            <option value="{{$v->id}}">{{$v->name}}</option>
                        @endforeach
                    </select>
                    <select name="shi" id="">
                        <option value="">请选择</option>
                    </select>
                    <select name="qu" id="">
                        <option value="">请选择</option>
                    </select>
                </div>
            </div> -->
            <div class="form-group">
                <label for="firstname" class="col-sm-2 control-label">是否上架</label>

                <div class="col-sm-10">
                    <input type="radio" name="goods_pop" value="1">是
                    <input type="radio" name="goods_pop" value="2" checked>否
                </div>
            </div>

            <div class="form-group">
                <label for="firstname" class="col-sm-2 control-label">商品LOG</label>

                <div class="col-sm-10">
                    <input type="file" name="goods_log" id="">
                </div>
            </div>
            <div class="form-group">
                <label for="firstname" class="col-sm-2 control-label">商品相册</label>

                <div class="col-sm-10">
                    <input type="file" multiple="multiple" name="goods_logs[]">
                </div>
            </div>
            </p>
        </div>
        <div class="tab-pane fade" id="ios">
            <p>
                <div class="form-group">
                    <label for="firstname" class="col-sm-2 control-label">商品类型</label>
                    <div class="col-sm-10">
                        <select id="type_id" class="form-control input-sm" id="firstname">
                            <option value="0" >请选择类型</option>
                            @foreach ($Typesdata as $v)
                                <option value="{{$v->type_id}}">{{$v->type_name}} </option>
                            @endforeach
                        </select>
                    </div><br/><br/><br/><br/><br/>
                    <table width="100%" id="attrTable" class='table table-bordered'>
                        <!-- <tr>
                            <td>前置摄像头</td>
                            <td>
                                <input type="hidden" name="attr_id_list[]" value="211">
                                <input name="attr_value_list[]" type="text" value="" size="20">  
                                <input type="hidden" name="attr_price_list[]" value="0">
                            </td>
                        </tr>
                        <tr>
                            <td><a href="javascript:;">[+]</a>颜色</td>
                            <td>
                                <input type="hidden" name="attr_id_list[]" value="214">
                                <input name="attr_value_list[]" type="text" value="" size="20"> 
                                属性价格 <input type="text" name="attr_price_list[]" value="" size="5" maxlength="10">
                            </td>
                        </tr> -->
                    </table>
                </div>
            </p>
        </div>
        <div class="tab-pane fade" id="date">
            <p>
                <div class="form-group">
                    <label for="firstname" class="col-sm-2 control-label">商品详情</label>
                    <div class="col-sm-10">
                        <textarea name="goods_intr" id="goods_intr" rows="10px" cols="60px" placeholder="请输入商品描述" >{{session('data')['goods_intr']}}</textarea>
                        <!-- 自定义报错信息 -->
                        <b style="color:red">{{$errors->first('goods_intr')}}</b>
                    </div>
                </div>
            </p>
        </div>
    </div>
    <!-- 提交按钮 -->
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-success">提交</button>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="{{url('Goods/show')}}" class="btn btn-primary">商品展示</a>
        </div>
    </div>

</form>
</body>
<script>
    // 滑动特效
    $(function () {
        $('#myTab li:eq(1) a').tab('show');
    });

    // 页面加载
    $(document).ready(function () {

        // 阻止提交
        $(document).on('submit', '#id_form', function () {
            // 验证用户
            var res = name();
            if (res == false) {
                return false;
            }
            // 价格
            var res = price();
            if (res == false) {
                return false;
            }
            // 库存
            var res = reper();
            if (res == false) {
                return false;
            }
            // 详情
            var res = intr();
            if (res == false) {
                return false;
            }
            return true;
        });

        // 名称
        function name() {
            // 获取文本框的值
            var goods_name = $('#goods_name').val();
            // 分类名字的正则
            var reg = /^[\u4e00-\u9fa5\w.\-]{1,9}$/;
            // 验证非空
            if (goods_name == '') {
                alert('商品名不能为空');
                return false;
            } else if (!reg.test(goods_name)) {
                alert('必须是汉字或者是数字下下划线组成1~9');
                return false;
            } else {
                var fala = false;
                $.ajax({
                    method: 'get',
                    url: "{{url('Goods/ajaxsole')}}",
                    data: {goods_name: goods_name},
                    async: false,
                }).done(function (count) {
                    if (count == 'on') {
                        alert('商品名称已经存在');
                        fala = false;
                    } else {
                        fala = true;
                    }
                });
                return fala;
            }
        }

        // 价格
        function price() {
            // 获取文本框的值
            var goods_price = $('#goods_price').val();
            // 分类名字的正则
            // var reg = /^\+?[1-9][0-9]*$/;
            // 验证非空
            if (goods_price == '') {
                alert('价格不能为空');
                return false;
            } else if (!reg.test(goods_price)) {
                alert('必须是数字');
                return false;
            }
        }


        // 详情
        function intr() {
            // 获取文本框的值
            var goods_intr = $('#goods_intr').val();
            // 分类名字的正则
            var reg = /^[\u4e00-\u9fa5\w.\-]{5,50}$/;
            // 验证非空
            if (goods_intr == '') {
                alert('详情不能为空');
                return false;
            } else if (!reg.test(goods_intr)) {
                alert('字数5~50');
                return false;
            }
        }

        // 三级联动做内容改变事件
        $(document).on('change', 'select', function () {
            // 获取id
            var id = $(this).val();
            // 获取当前
            var obj = $(this);
            // nextAll下面所有的
            obj.nextAll('select').html("<option value=''>请选择...</option>");
            // 传值
            $.get('/Goods/getAera', {id: id}, function (res) {
                if (res.code == '00000') {
                    var str = '<option>请选择</option>'
                    // 数据循环
                    $.each(res.data, function (i, k) {
                        str += '<option value=' + k.id + '>' + k.name + '</option>';
                    });
                    obj.next().html(str);
                }
            }, 'json')
        })

    });

    /**
        * 根据类型查属性
        *      1、select下来菜单一个点击事件-->change
        *      2、获取当前点的id。获取当前-->$(this),val() - 设置或返回表单字段的值
        *      3、ajax请求后台,数据，数据类型
        *      4、回调函数，$.each->(循环) i,v
        *      5、判断是否是可选属性   \-->一行   '++'js拼接
    */
    $('#type_id').on("change",function(){
        var type_id = $(this).val();
        $.ajax({
            url:"{{url('Goods/getAttr')}}",
            data:{type_id:type_id},
            dataType:"json",
            success:function(res){
                // 每次请求清空数据
                $('#attrTable').empty();
                $.each(res,function(i,v){
                    if(v.attr_type == 1){
                        // 可选属性
                        var tr = '<tr align="center">\
                                    <td><a href="javascript:;" id="addRow">[+]</a>'+v.attr_name+'</td>\
                                    <td>\
                                        <input type="hidden" name="attr_id_list[]" value="'+v.attr_id+'"> <br/>\
                                        属性性能 <input name="attr_value_list[]" type="text" value="" size="20">\
                                        属性价格 <input type="text" name="attr_price_list[]" value="" size="5" maxlength="10">\
                                    </td>\
                                </tr>';
                    }else{
                        var tr ='<tr align="center">\
                                    <td>'+v.attr_name+'</td>\
                                    <td>\
                                        <input type="hidden" name="attr_id_list[]" value="'+v.attr_id+'">\
                                        参数 <input name="attr_value_list[]" type="text" value="" size="20">  <br/>\
                                        <input type="hidden" name="attr_price_list[]" value="0">\
                                    </td>\
                                </tr>'; 
                    }
                    // 追加
                    $('#attrTable').append(tr);
                })
            }
        });
    })

    // 加减号
    $(document).on('click','#addRow',function(){
        
        var value = $(this).html();
        // alert(value);
        if(value == '[+]'){
            $(this).html("[-]");
            var tr = $(this).parent().parent();
            var tr_clone = tr.clone();
            $(this).html("[+]");
            tr.after(tr_clone);
        }else{
            // 点击减号
            $(this).parent().parent().remove();
        }
    })
</script>
</html>