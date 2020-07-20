@extends('index.layouts_index.layouts')
@section('title', '商城分类')
@section('content')
    <header class="mui-bar mui-bar-nav seach-header classification">
        <div class="top-sch-box flex-col">
            <div class="centerflex">
                <i class="fdj  icon  iconfont icon-sousuo1"></i>
                <input type="text" placeholder="连衣裙就是你的女人味儿" class="sch-txt"/>
                <button class="search__button">搜索</button>
            </div>
        </div>
    </header>
    <div class="nav-bottom">
        <div class="classification-list">
            <!-- tab栏 -->
            <div class="list-nav-tabs">
                <ul id="tabs">
                    @foreach($cateInfo as $v)
                        <li class="add" value="{{$v['class_id']}}">
                            <a href="#" title="tab1">{{$v['class_name']}}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <!-- 对应显示内容 -->
            <div id="content">
                <div id="tab1" class="item show">
                    <ul class="pattern-list replace">
                        @foreach($goodInfo as $k=>$v)
                                @if($k % 2 == 0)
                                    <li class="mui-card-footer">
                                @endif
                                <div class="mui-card">
                                    <a href="{{url('Index/goodsInfo')}}?goods_id={{$v['goods_id']}}">
                                        <div class="mui-card-header mui-card-media" style="height:40vw;">
                                            <img class="w100" src="\{{$v['goods_log']}}"/>
                                        </div>
                                        <div class="mui-card-content">
                                            <div class="mui-card-content-inner">
                                                <p style="color: #333;">{{$v['goods_name']}}</p>
                                            </div>
                                        </div>
                                        <div class="pattern-list__p">
                                            <p class="font-color-pink">￥<label>{{$v['goods_price']}}</label></p>
                                            <!-- <p>库存<label>538</label></p> -->
                                        </div>
                                    </a>
                                </div>
                                @if($k % 2 != 0)
                                    </li>
                                @endif
                        @endforeach
                    </ul>
                </div>
                
            </div>
        </div>
    </div>
        <!-- 底下导航 -->
        <div class="nav-footer">
            <a href="{{url('/')}}">
                <span class="mui-icon mui-icon-home"></span>
                <span class="mui-tab-label">首页</span>
            </a>
            <a href="{{url('Index/classIndex')}}"  class="icon-active">
                <span class="mui-icon mui-icon-list"></span>
                <span class="mui-tab-label">分类</span>
            </a>
            <a href="{{url('Index/goodsCart')}}">
                <span class="mui-icon mui-icon-extra mui-icon-extra-cart"></span>
                <span class="mui-tab-label">购物车</span>
            </a>
            <a href="examples/new-mine.html">
                <span class="mui-icon mui-icon-contact"></span>
                <span class="mui-tab-label">个人中心</span>
            </a>
		</div>
    <script>
        $(function () {
            $('#tabs a').click(function (e) {
                e.preventDefault();
                $('#tabs li').removeClass("current").removeClass("hoverItem");
                $(this).parent().addClass("current");
                $("#content div").removeClass("show");
                $('#' + $(this).attr('title')).addClass('show');
            });

            $('#tabs a').hover(function () {
                if (!$(this).parent().hasClass("current")) {
                    $(this).parent().addClass("hoverItem");
                }
            }, function () {
                $(this).parent().removeClass("hoverItem");
            });
        });
    </script>
    <script>
    //jquery特效
    $(document).on('click','.add',function(){
        
        var _this = $(this);
       
        var class_id = _this.val();
        _this.addClass('current').siblings('li').removeClass('current');
        //通过ajax技术传给控制器
        $.ajax({
            url:"{{url('Index/goodsCateList')}}",
            type:"post",
            data:{class_id:class_id},
            success:function(res){
                // 打印数据
                // console.log(res);
                var div = "";
                $.each(res,function(i,v){
                    if(res) {
                        if(i%2==0){
                            div += ' <li class="mui-card-footer">\
                                            <div class="mui-card">\
                                                <a href="{{url('Index/goodsInfo')}}?goods_id='+v.goods_id+'">\
                                                    <div class="mui-card-header mui-card-media" style="height:40vw;">\
                                                        <img class="w100" src="/'+v.goods_log +'">\
                                                    </div>\
                                                    <div class="mui-card-content">\
                                                        <div class="mui-card-content-inner">\
                                                            <p style="color: #333;">'+ v.goods_name +'</p>\
                                                        </div>\
                                                    </div>\
                                                    <div class="pattern-list__p">\
                                                        <p class="font-color-pink">￥<label>'+v.goods_price+'</label></p>\
                                                    </div>\
                                                </a>\
                                            </div>';
                        }else{
                            div += '<div class="mui-card">\
                                        <a href="{{url('Index/goodsInfo')}}?goods_id='+v.goods_id+'">\
                                            <div class="mui-card-header mui-card-media" style="height:40vw;">\
                                                <img class="w100" src="/'+v.goods_log +'">\
                                            </div>\
                                            <div class="mui-card-content">\
                                                <div class="mui-card-content-inner">\
                                                    <p style="color: #333;">'+ v.goods_name +'</p>\
                                                </div>\
                                            </div>\
                                            <div class="pattern-list__p">\
                                                <p class="font-color-pink">￥<label>'+v.goods_price+'</label></p>\
                                            </div>\
                                        </a>\
                                    </div>\
                                </li>'
                        }
                    }
                    $('.replace').html(div);
                });
            }
        });
    });
</script>
@endsection