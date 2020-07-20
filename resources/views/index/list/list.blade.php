@extends('index.layouts_index.layouts')
@section('title', '商品列表')
@section('content')
        <header class="mui-bar mui-bar-nav">
			<a class="mui-action-back mui-icon mui-icon-left-nav mui-pull-left"></a>
			<h1 class="mui-title">商品</h1>
		</header>
		<div class="new-pattern" style="margin-top:44px;">
			<img class="w100" class="home-imgtit" src="images/hometit1.jpg" alt="" />
			<ul class="pattern-list">
				@foreach($goodsList as $k=>$v)
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
		<!-- 底下导航 -->
		<div class="nav-footer">
                <a href="{{url('/')}}"  class="icon-active">
                    <span class="mui-icon mui-icon-home"></span>
                    <span class="mui-tab-label">首页</span>
                </a>
                <a href="{{url('Index/classIndex')}}" >
                    <span class="mui-icon mui-icon-list"></span>
                    <span class="mui-tab-label">分类</span>
                </a>
                <a href="examples/new-shopping-card.html">
                    <span class="mui-icon mui-icon-extra mui-icon-extra-cart"></span>
                    <span class="mui-tab-label">购物车</span>
                </a>
                <a href="examples/new-mine.html">
                    <span class="mui-icon mui-icon-contact"></span>
                    <span class="mui-tab-label">个人中心</span>
                </a>
		</div>
@endsection