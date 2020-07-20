<!DOCTYPE html>
<html>
	<head>
        <base href="/static/index/">
		<meta charset="utf-8">
		<title>商品购物车</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<!--标准mui.css-->
		<link rel="stylesheet" href="css/mui.min.css">
		<!--App自定义的css-->
		<link rel="stylesheet" type="text/css" href="css/app.css" />
		<link rel="stylesheet" type="text/css" href="css/icons-extra.css">
		<!--自定义iconfont-->
		<link rel="stylesheet" type="text/css" href="css/iconfont.css">
        <link rel="stylesheet" type="text/css" href="css/shopping-cart.css">
        <script src="js/mui.min.js"></script>
		<script src="js/jquery.min.js"></script>
		<script type="text/javascript">
			//定义全局变量
			var i = 0;
			//金额总和
			var money = 0;
			//计算合计价格
			var cart_money = new Object();
			//全部商品ID
			var cart_id = new Object();
			//备份商品ID，用于全选后去掉全选又再次全选
			var cart_id_copy = new Object();
		</script>
		<style>
			.insertClass{background-color: LightGray}
		</style>
	</head>

	<body>
		<header class="mui-bar mui-bar-nav">
			<a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
			<h1 class="mui-title">购物车</h1>
			<a class="rig_shai" id="rem_s" href="javascript:void(0)" style="margin-right: 2%;position: absolute; top: 5px; right: 3%;">编辑</a>
		</header>
		<div style="height:44px;"></div>
		<form method="post" name="cart_form" target="_self" id="cart_form" action="">
			<!--list-->
			<div class="commodity_list_box">
				<!--商品列表-->
				<div class="commodity_box " >
					<div class="commodity_list">
						<!--店名信息-->
						<!--商品-->
						<ul class="commodity_list_term">
						@foreach($CartList['cartInfo'] as $v)
							<li class="select found" goods_num="{{$v['goods_num']}}" cart_id="{{$v['cart_id']}}">
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="checkbox" class="box" style="transform: scale(1,1);">
								<img src="/{{$v['goods_log']}}" />
								<div class="div_center " >
									<h4>{{$v['goods_name']}}</h4>
									@foreach($v['attr_value'] as $kk => $vv)
										<span>{{$vv['attr_name']}}:<label class="mr-6">{{$vv['attr_value']}}</label></span>
									@endforeach
									<p class="now_value"><i>￥</i><b class="qu_su">{{$v['buy_num'] * $v['add_price']}}</b></p>
								</div>
								<div class="div_right">
									<i class="lessValue">-</i>
										<span class="zi" class="buy_num">{{$v['buy_num']}}</span>
									<i class="addValue">+</i>
								</div>
							</li>
							@endforeach
						</ul>
						
					</div>
				</div>
				
				<!-- 商品列表 end -->
			</div>
			<!-- end -->

			<!-- footer -->
			<div style="height:55px;"></div>
			<div class="settle_box">
				<ul class="all_check select">
					<li><input type="checkbox" class="allBox" style="transform: scale(1,1);"><div>全选</div></li>
				</ul>
				<ul class="total_amount">
					<li style="display: flex;">合计：<p id="total_price">¥<b>0</b></p></li>
					<li style="display: flex;">
						<a class="settle_btn" href="javascript:void(0);" id="confirm_cart">结算</a>
					</li>
				</ul>
				<a class="settle_btn allDel" href="javascript:void(0);" id="confirm_cart1" onclick="big_cart_remove()">删除</a>
			</div>
			<!-- end -->
		</form>
		<!-- 底下导航 -->
        <div class="nav-footer">
            <a href="{{url('/')}}">
                <span class="mui-icon mui-icon-home"></span>
                <span class="mui-tab-label">首页</span>
            </a>
            <a href="{{url('Index/classIndex')}}" >
                <span class="mui-icon mui-icon-list"></span>
                <span class="mui-tab-label">分类</span>
            </a>
            <a href="{{url('Index/goodsCart')}}"  class="icon-active">
                <span class="mui-icon mui-icon-extra mui-icon-extra-cart"></span>
                <span class="mui-tab-label">购物车</span>
            </a>
            <a href="examples/new-mine.html">
                <span class="mui-icon mui-icon-contact"></span>
                <span class="mui-tab-label">个人中心</span>
            </a>
		</div>
	
		<script>
			//点击加号
			$(document).on('click','.addValue',function(){
				var _this = $(this);
				var goods_num = parseInt(_this.parent().parent('li').attr('goods_num'));
				var buy_num = parseInt(_this.prev('span').text());
				var cart_id = _this.parent().parent('li').attr('cart_id');

				if(buy_num >= goods_num){
					alert('商品数量超限！');
					_this.prev('span').text(goods_num);
				}else{
					buy_num += 1;
					_this.prev('span').text(buy_num);
				}
				//购买数量改为文本框的值
				changeNum(buy_num,cart_id);
				
				//重新获取小计
				getTotal(_this,cart_id);

				//当前行复选框选中
				changeChecked(_this);

				// 颜色
				changeColor(_this);

				//重新获取总价
				getTotalCount()
			});

			//点击减号
			$(document).on('click','.lessValue',function(){
				var _this = $(this);
				var buy_num = parseInt(_this.next('span').text());
				var cart_id = _this.parent().parent('li').attr('cart_id');
				if(buy_num <=1){
					_this.next('span').text(1)
				}else{
					buy_num -= 1;
					_this.next('span').text(buy_num);
				}

				//购买数量改为文本框的值
				changeNum(buy_num,cart_id);
				
				//重新获取小计
				getTotal(_this,cart_id);

				//当前行复选框选中
				changeChecked(_this);

				// 颜色
				changeColor(_this);

				//重新获取总价
				getTotalCount()
			});


		    //购买数量改为文本框的值
		    function changeNum(buy_num,cart_id){
				$.ajax({
					url:"{{url('/Index/changeNum')}}",
					type:"post",
					data:{cart_id:cart_id,buy_num:buy_num},
					dataType:"json",
					async:false,
					success:function(res){
						if(res.error != 200){
							return false;
						}
						$(".dl").load(location.href+" .dl"); 
						
						// parent.location.reload();
						return true;
					}
				});
			}
			
			
			//点击全选
			$(document).on('click','.allBox',function(){
				var _this = $(this);
				var status = $(".allBox").prop('checked');
				$(".box").prop('checked',status);

				if(status == true){
					$(".found").addClass('insertClass');
				}else{
					$(".found").removeClass('insertClass');
				}
				//重新获取总价
				getTotalCount()
			});

			//点击复选框
			$(document).on('click','.box',function(){
				var _this = $(this);
				var status = $(this).prop('checked');

				//颜色改变
				if(status == true){
					_this.parent('li').addClass('insertClass');
				}else{
					_this.parent('li').removeClass('insertClass');
				}

				//重新获取总价
				getTotalCount()
			});

			//重新获取总价
			function getTotalCount(){
				var _box = $(".box:checked");
				var cart_id = "";
				if(_box.length > 0){
					_box.each(function(index){
						cart_id += $(this).parent('li').attr('cart_id')+',';
					});
					cart_id = cart_id.substr(0,cart_id.length-1);
					$.ajax({
						url:"{{url('Index/getTotalCount')}}",
						type:"post",
						data:{cart_id:cart_id},
						dataType:"json",
						success:function(res){
							$("#total_price").html("¥"+'<b>'+res.data+'</b>')
						}
					})
				}else{
					$("#total_price").html("¥<b>0</b>");
				}
			}

			//重新获取小计
			function getTotal(_this,cart_id){
				$.ajax({
					url:"{{url('Index/getTotal')}}",
					type:"post",
					data:{cart_id:cart_id},
					success:function(res) {
						_this.parent().parent('li').find('.total').text(res);
					}
				})
			}

			/* 编辑商品  */
			var topb = 0;
			$("#rem_s").click(function() {
				if(topb == 0) {
					$(this).text("完成");
					$(".total_amount").hide(); /* 合计  */
					$("#confirm_cart").hide(); /* 结算  */
					$("#confirm_cart1").show(); /* 删除 */
					topb = 1;
				} else {
					topb = 0;
					$(this).text("编辑");
					$(".total_amount").show(); /* 合计  */
					$("#confirm_cart").show(); /* 结算  */
					$("#confirm_cart1").hide(); /* 删除 */
				}
			})

			//点击批量删除
			// $(document).on('click','.allDel',function(){
			// 	//获取选中复选框的商品
			// 	var _box = $(".box:checked");
			// 	var cart_id = "";
			// 	if(_box.length>0){
			// 		if(confirm('您确认要移除这些商品吗?')){
			// 			_box.each(function(index){
			// 				cart_id += $(this).parent().attr('cart_id')+',';
			// 			});
			// 			cart_id = cart_id.substr(0,cart_id.cart_id-1);
			// 			alert(cart_id);
			// 			$.ajax({
			// 				url:"{{url('Index/delCart')}}",
			// 				type:"post",
			// 				data:{cart_id:cart_id},
			// 				success:function(res){
			// 					if(res.error==200){
			// 						_box.parent().remove();
			// 						$("#total_price").html("¥<b>0</b>");
			// 					}else{
			// 						alert(res.msg);
			// 						return false;
			// 					}
			// 				}
			// 			})
			// 		}else{
			// 			return false;
			// 		}
			// 	}else{
			// 		alert('请选择需删除的商品！')
			// 	}
			// });

			//当前行复选框选中
			function changeChecked(_this){
				_this.parent().parent('li').find('.box').prop('checked',true);
			}

			//当前行颜色改变
			function changeColor(_this){
				_this.parent().parent('li').addClass('insertClass');
			}


			
		</script>
	</body>

</html>
