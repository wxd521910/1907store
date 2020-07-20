<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('Index')->group(function(){
    // 登陆
    Route::any('regIster','Api\Login@register');             //执行注册接口
    Route::any('loginDo','Api\Login@loginDo');               //执行登陆接口
    Route::any('send','Api\Login@send');                     //手机短信接口

    // 首页
    Route::any('goodsList','Api\Index@goodsList');            //商品列表 分类 接口
    
    // 商品
    Route::any('goodsInfo','Api\Goods@goodsInfo');                //商品详情接口
    Route::any('CartCar','Api\Cart@CartCar');                  //购物车接口
    Route::any('CartList','Api\Cart@CartList');                  //购物车列表
    Route::any('goodsPrice','Api\Goods@goodsPrice');              //Ajax点击价钱接口
});