@extends('index.layouts_index.layouts')
@section('title', '商城首页')
@section('content')
    <header class="mui-bar mui-bar-nav seach-header">
        <div class="top-sch-box flex-col">
            <a href="examples/search.html">
                <div class="centerflex">
                    <i class="fdj  icon  iconfont icon-sousuo1"></i>

                    <div class="sch-txt">连衣裙就是你的女人味儿</div>
                    <span class="shaomiao"><i class="iconfont icon-saoma"></i></span>
                </div>
            </a>
        </div>
        <a class="btn" href="examples/new-newsCenter.html">
            <span class="icon iconfont icon-xiaoxi"></span>
        </a>
        <a class="btn" href="examples/new-shopping-card.html">
            <span class="icon iconfont icon-gouwuche1"></span>
        </a>
    </header>
    <div class="nav-bottom">
        <!--图片轮播-->
        <div id="slider" class="mui-slider">
            <div class="mui-slider-group mui-slider-loop">
                <!-- 额外增加的一个节点(循环轮播：第一个节点是最后一张轮播) -->
                <div class="mui-slider-item mui-slider-item-duplicate"><a href="#"><img src="images/banner1.jpg"></a>
                </div>
                <div class="mui-slider-item"><a href="#"><img src="images/banner1.jpg"></a></div>
                <div class="mui-slider-item"><a href="#"><img src="images/banner2.jpg"></a></div>
                <div class="mui-slider-item"><a href="#"><img src="images/banner1.jpg"></a></div>
                <div class="mui-slider-item"><a href="#"><img src="images/banner2.jpg"></a></div>
                <div class="mui-slider-item mui-slider-item-duplicate"><a href="#"><img src="images/banner1.jpg"></a>
                </div>
            </div>
            <div class="mui-slider-indicator">
                <div class="mui-indicator mui-active"></div>
                <div class="mui-indicator"></div>
                <div class="mui-indicator"></div>
                <div class="mui-indicator"></div>
            </div>
        </div>
        <!--商品分类-->
        <div class="mui-content new-pattern-con">
            <ul class="mui-table-view mui-grid-view mui-grid-12 pattern-con-icon">
                @foreach ($cateInfo as $v)
                    <li class="mui-table-view-cell mui-media mui-col-xs-3 mui-col-sm-3">
                        <a href="{{url('Index/goodsList')}}?class_id={{$v->class_id}}">
                            <span class="mui-icon iconfont icon-remenshangpin"></span>
                            <div class="mui-media-body" >{{$v->class_name}}</div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <!--新款发售-->
        <div class="new-pattern ">
            <img class="w100" class="home-imgtit" src="images/hometit1.jpg" alt=""/>
            <ul class="pattern-list goodsCate">
           
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
       	<!-- 底下导航 -->
           <div class="nav-footer">
            <a href="{{url('/')}}" class="icon-active">
                <span class="mui-icon mui-icon-home"></span>
                <span class="mui-tab-label">首页</span>
            </a>
            <a href="{{url('Index/classIndex')}}" >
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
@endsection
