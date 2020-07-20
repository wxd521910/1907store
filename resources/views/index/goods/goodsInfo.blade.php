<!DOCTYPE html>
<html>

	<head>
        <!-- <base href="/static/index/"> -->
		<meta charset="utf-8">
		<title>商品详情</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
        <script src="/static/index/js/mui.min.js"></script>
		<script src="/static/index/js/jquery.min.js"></script>
		<!--标准mui.css-->
		<link rel="stylesheet" href="/static/index/css/mui.min.css">
		<!--App自定义的css-->
		<link rel="stylesheet" type="text/css" href="/static/index/css/app.css" />
		<link rel="stylesheet" type="text/css" href="/static/index/css/icons-extra.css">
		<!--自定义iconfont-->
		<link rel="stylesheet" type="text/css" href="/static/index/css/iconfont.css">
		<link rel="stylesheet" type="text/css" href="/static/index/css/pro2.css">
		<style type="text/css">
			#txtCon{width:100px; height:33px;}
		</style>
	</head>

	<body style="background: #fff;">
		
		<div class="new-personal-details">
			<!--图片轮播-->
			<div id="slider" class="mui-slider">
				<div class="mui-slider-group mui-slider-loop">
					<!-- 额外增加的一个节点(循环轮播：第一个节点是最后一张轮播) -->
					@foreach($goodsInfo['data']['goods']['goods_logs'] as $v)
                        <div class="mui-slider-item mui-slider-item-duplicate">
                            <a href="javascript:;">
                                <img src="/{{$v}}"   height="350">>
                            </a>
                        </div>
                    @endforeach
				</div>
				<div class="mui-slider-indicator">
					<div class="mui-indicator"></div>
					<div class="mui-indicator  mui-active"></div>
					<div class="mui-indicator"></div>
					<div class="mui-indicator"></div>
				</div>
			</div>

			<ul class="deails-con">
                <li class="deails-con-title">{{$goodsInfo['data']['goods']['goods_name']}}</li>
                <li class="deails-con-price">
                    <span>￥{{$goodsInfo['data']['goods']['goods_price']}}</span>
                    <!-- <span>库存:<label>266</label></span> -->
                </li>
                <li class="deails-con-text">商品详情</li>
                <li class="deails-con-text__li">
                    {{$goodsInfo['data']['goods']['goods_intr']}}
                </li>
			</ul>
			<!-- 弹出 -->
			<div class="flick-menu-mask" style=""></div>
			<div class="spec-menu">
				<div class="spec-menu-content spec-menu-show" style="display: block;">
					<div class="spec-menu-top bdr-b">
						<div class="spec-first-pic"> 
                            <img id="spec_image" src="/{{$goodsInfo['data']['goods']['goods_log']}}" />
                        </div>
						<a class="rt-close-btn-wrap spec-menu-close">
							<p class="flick-menu-close tclck">
                                <img src="/static/index/images/close.png" width="24" height="24" /> 
                            </p>
						</a>
                        <div class="spec-price" id="specJdPri" style="display: block"> 
                            <span class="yang-pic spec-yang-pic"> 
                                <img src="/static/index/images/rmb.png" /> 
                            </span> 
							<span id="spec_price" class="price_total"> {{$goodsInfo['data']['goods']['goods_price']}} </span> 
							
                        </div>
                        <!-- 参数 -->  
                            @foreach($goodsInfo['data']['args'] as $k=>$v)
                                @foreach($v as $vv)
                                    <div id="specWeightDiv" class="spec-weight">
                                        <span>{{$vv['attr_name']}}</span> 
										<span id="spec_weight">{{$vv['attr_value']}}</span> 
									</div>
                                @endforeach
                            @endforeach
					</div>
                    <!-- 可选属性 -->
					<div class="nature-container" id="natureCotainer">
                        @foreach($goodsInfo['data']['spec'] as $k=>$v)
                            <div class="pro-color"> <span class="part-note-msg"> {{$k}} </span>
                                <p id="color">
                                     @foreach($v as $vv)
                                        <input type="hidden" value="{{$vv['goods_attr_id']}}">
                                        <a  class="a-item defaultChecked J_ping">{{$vv['attr_value']}}</a>
                                    @endforeach
                                </p>
                            </div>
						@endforeach
						<div class="pro-color"> <span class="part-note-msg">数量</span>
							<p class="color">
								<input class="btn btn-default" type="button" id="addValue" value="+">
						
								<input type="text"  id="txtCon"  value="1" class="buy_num" />
								
								<input class="btn btn-default" type="button" id="lessValue" value="-">
							</p>
						</div>
					</div>
					<button class="true-button tclck">确定</button>
				</div>
			</div>
		</div>
		<ul class="details-price__button">
			<li class="add-cart clickwn">
				<span class="icon iconfont icon-gouwuche"></span>
				<p>加入购物车</p>
			</li>
			<li class="buy">
				<a href="new-buy.html">立即购买</a>
			</li>
		</ul>
		<div class="icon-gouCenter"><a href="new-shopping-card.html"><span class="icon iconfont icon-gou"></span></a></div>
		
		<script type="text/javascript" charset="utf-8">
			mui.init({
				swipeBack: true
			});
			var slider = mui("#slider");
			slider.slider({
				interval: 2000 //自动轮播周期，若为0则不自动播放，默认为0；
			});
		</script>
		<script type="text/javascript">
			$(function() {
				$(".clickwn").click(function() {
					$(".flick-menu-mask").show();
					$(".spec-menu").show();
				})
				$(".tclck").click(function() {
					$(".flick-menu-mask").hide();
					$(".spec-menu").hide();
				})
				$('#cool').bind('input propertychange', function() { /* alert(this.value);*/
					$('.amount').html(this.value)
				}).bind('input input', function() {});
				$('#color a').click(function() {
					var cook = $(this).index();
					$('#color a').eq(cook).addClass('selected').siblings().removeClass('selected');
				})
			})
        </script>
        <script>
            // 点击改变金钱数目
            $(document).on('click','.defaultChecked',function(){
                var _this = $(this);
                _this.addClass('selected').siblings('a').removeClass('selected');
                //改变金钱数目
                var goods_attr_id = "";
                $('.selected').each(function(index){
                    goods_attr_id += $(this).prev('input').val()+',';
                });
                var goods_attr_id = goods_attr_id.substr(0,goods_attr_id.length-1);
                // console.log(goods_attr_id)
                $.ajax({
                    url:"{{'/Index/goodsPrice'}}",
                    type:"post",
                    data:{goods_attr_id:goods_attr_id},
                }).done(
                    function(res){
                        console.log(res);
                        $('.price_total').text(res.goods_price);
                    }
                );
			})
			
			//点击加号
			$(document).on('click','#addValue',function(){
				var goods_num = parseInt($("#goods_num").val());   //库存值
				var buy_num = parseInt($(".buy_num").val());                       //购买数量
				if(buy_num >= goods_num){
					$(".buy_num").val(goods_num);    //最大为库存值
				}else{
					buy_num += 1;
					$(".buy_num").val(buy_num);
				}
			});

			//点击减号
			$(document).on('click','#lessValue',function(){
				var buy_num = parseInt($(".buy_num").val());  //获取文本框值
				if(buy_num <= 1){
					$(".buy_num").val(1);
				}else{
					buy_num -= 1;
					$(".buy_num").val(buy_num);
				}
			});

			//失去焦点
			$(document).on('blur','.buy_num',function(){
				var goods_num = parseInt($("#goods_num").val());   //库存值
				var buy_num = $(".buy_num").val();  //获取文本框值
				//检测是否为数字
				var reg = /^\d+$/;
				if(!reg.test(buy_num) || parseInt(buy_num) <=1){
					$(".buy_num").val(1);
				}else if(parseInt(buy_num) >= goods_num){
					$(".buy_num").val(goods_num);
				}else{
					$(".buy_num").val(parseInt(buy_num));
				}
			});

			// 加入购物车
			@if(session('userList'))
				var is_login = 1;
			@else
				var is_login = 0;
			@endif
			$(document).on('click','.true-button',function(){
				if(is_login==1){
					var goods_id = "{{$goodsInfo['data']['goods']['goods_id']}}";
					var buy_num = $(".buy_num").val();
					var goods_attr_id = "";
					$('.selected').each(function(index){
						goods_attr_id += $(this).prev('input').val()+',';
					});
					goods_attr_id = goods_attr_id.substr(0,goods_attr_id.length-1);
					if($(".selected").length<=0){
						alert('请选择商品属性!');
						return;
					}
					// 传入控制器
					$.ajax({
						url:"{{url('Index/ajaxCart')}}",
						type:"post",
						data:{goods_id:goods_id,buy_num:buy_num,goods_attr_id:goods_attr_id},
						dataType:"json",
						success:function(res){
							console.log(res);
							if(res.error==1){
								alert(res.msg);
								location.href="{{url('login/login')}}";
							}else if(res.error==2){
								alert(res.msg);
							}else if(res.error==200){
								alert(res.msg);
							}
						}
					})
				}else{
					alert('请先登陆');
					location.href="{{url('login/login')}}";
				}

			});
        </script>
	</body>

</html>

<!-- 商品id   购买数量   价格   规格    -->