<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Route::get('/', function () {
//     return view('welcome');
// });

// 前台
// Route::get('/', function () {
//     return view('index.index.index');
// });
Route::any('/', 'Index\IndexController@index');                                 //首页

Route::any('Index/goodsList', 'Index\IndexController@goodsList');              //商品列表

Route::any('Index/classIndex','Index\IndexController@classIndex');            //分类列表

Route::any('Index/goodsCateList', 'Index\IndexController@goodsCateList');      //ajax点击分类
// 前台商品
Route::any('Index/goodsInfo', 'Index\GoodsController@goodsInfo');              //商品详情

Route::any('Index/goodsPrice','Index\GoodsController@goodsPrice');            //商品详情价钱特效ajax

Route::any('Index/ajaxCart','Index\CartController@ajaxCart');               //ajax添加购物车

Route::any('Index/goodsCart','Index\CartController@goodsCart');               //购物车列表

Route::any('Index/getTotal', 'Index\CartController@getTotal');                //重新获取小计

Route::any('Index/changeNum', 'Index\CartController@changeNum');               //购买数量+改为文本框的值

Route::any('Index/getTotalCount', 'Index\CartController@getTotalCount');  //购物车列表/重新获取总价

Route::any('Index/delCart', 'Index\CartController@delCart');                    //购物车列表/点击删除



// 前台
Route::prefix('login')->group(function(){
    Route::any('sign','Index\LoginController@sign');                    //注册视图
    // Route::any('mail','Index\LoginController@mail');                    //邮箱注册视图
    // Route::any('mails','Index\LoginController@mails');                    //邮箱注册执行
    Route::any('SignAdd','Index\LoginController@SignAdd');             //执行注册
    Route::any('sendAdd','Index\LoginController@sendAdd');              //验证码
    Route::any('login','Index\LoginController@login');                  //登陆视图
    Route::any('loginAdd','Index\LoginController@loginAdd');            //执行登陆
}); 



// ---------------------------------------------------------------------------------------------------------------
// 后台
Route::get('/Admin/login', function () {
    return view('admin.login.login');
});

// 登陆
Route::prefix('Login')->group(function(){
    Route::get('index','Admin\LoginController@index');                   //登陆视图
    Route::post('add','Admin\LoginController@add');                      //执行登陆
    Route::get('logout','Admin\LoginController@logout');                 //退出
    // Route::get('navigation','Admin\LoginController@navigation');                 //退出
});

// 权限
Route::prefix('Power')->middleware('checkLogin','checkPower')->group(function(){
    Route::any('index','Admin\PowerController@index');                   //添加视图
    Route::any('add','Admin\PowerController@add');                      //执行添加
    Route::any('show','Admin\PowerController@show');                     //展示
    Route::any('ajaxsole','Admin\PowerController@ajaxsole');             //ajax验证唯一性
});

// 角色
Route::prefix('Role')->middleware('checkLogin','checkPower')->group(function(){
    Route::any('index','Admin\RoleController@index');                   //添加视图
    Route::any('add','Admin\RoleController@add');                      //执行
    Route::any('show','Admin\RoleController@show');                     //展示列表
});

// 分类
Route::prefix('category')->middleware('checkLogin','checkPower')->group(function(){
    Route::get('index','Admin\ClassifyConrtoller@index');               //添加视图
    Route::post('add','Admin\ClassifyConrtoller@add');                  //执行添加
    Route::get('ajaxsole','Admin\ClassifyConrtoller@ajaxsole');         //ajax的唯一性
    Route::get('show','Admin\ClassifyConrtoller@show');                 //列表展示
    Route::get('del/{id}','Admin\ClassifyConrtoller@del');              //删除
    Route::get('unp/{id}','Admin\ClassifyConrtoller@unp');              //修改页面
    Route::post('unps/{id}','Admin\ClassifyConrtoller@unps');           //执行修改
});

// 管理员
Route::prefix('Admins')->middleware('checkLogin','checkPower')->group(function(){
    Route::get('greet','Admin\AdminsController@greet');                 //首页
    Route::get('index','Admin\AdminsController@index');                 //添加视图
    Route::post('add','Admin\AdminsController@add');                    //执行添加
    Route::get('ajaxsole','Admin\AdminsController@ajaxsole');           //ajax的唯一性
    Route::get('show','Admin\AdminsController@show');                   //列表展示
    Route::get('del/{id}','Admin\AdminsController@del');                //删除
    Route::get('unp/{id}','Admin\AdminsController@unp');                //修改页面
    Route::post('unps/{id}','Admin\AdminsController@unps');              //执行修改
    Route::get('ajaxunp','Admin\AdminsController@ajaxunp');              //极点技改
});

// 品牌
Route::prefix('Brand')->middleware('checkLogin','checkPower')->group(function(){
    Route::get('index','Admin\BrandConrtoller@index');                  //添加视图
    Route::post('add','Admin\BrandConrtoller@add');                     //执行添加
    Route::get('ajaxsole','Admin\BrandConrtoller@ajaxsole');            //ajax的唯一性
    Route::get('show','Admin\BrandConrtoller@show');                    //列表展示
    Route::get('del/{id}','Admin\BrandConrtoller@del');                 //删除
    Route::get('unp/{id}','Admin\BrandConrtoller@unp');                 //修改页面
    Route::post('unps/{id}','Admin\BrandConrtoller@unps');              //执行修改
    Route::get('ajaxunp','Admin\BrandConrtoller@ajaxunp');              //极点技改
});

// 商品
Route::prefix('Goods')->middleware('checkLogin','checkPower')->group(function(){
    Route::any('index','Admin\GoodsConrtoller@index');                  //添加视图
    Route::post('add','Admin\GoodsConrtoller@add');                     //执行添加
    Route::get('ajaxsole','Admin\GoodsConrtoller@ajaxsole');            //ajax的唯一性
    Route::get('show','Admin\GoodsConrtoller@show');                    //列表展示
    Route::get('del/{id}','Admin\GoodsConrtoller@del');                 //删除
    Route::get('unp/{id}','Admin\GoodsConrtoller@unp');                 //修改页面
    Route::post('unps/{id}','Admin\GoodsConrtoller@unps');              //执行修改
    Route::get('ajaxunp','Admin\GoodsConrtoller@ajaxunp');              //极点技改
    Route::get('getAera','Admin\GoodsConrtoller@getAera');              //三级联动
    Route::get('getAttr','Admin\GoodsConrtoller@getAttr');              //属性
});

// sku
Route::prefix('Sku')->middleware('checkLogin','checkPower')->group(function(){
    Route::get('index','Admin\SkuController@index');                   //添加视图
    Route::any('add','Admin\SkuController@add');                       //执行添加
});

// 类型
Route::prefix('Type')->middleware('checkLogin','checkPower')->group(function(){
    Route::get('index','Admin\TypeController@index');                   //添加视图
    Route::any('add','Admin\TypeController@add');                       //执行添加
    Route::get('show','Admin\TypeController@show');                     //列表展示
    Route::any('AjaxAdd','Admin\TypeController@AjaxAdd');               //ajax唯一
});

// 属性
Route::prefix('Attr')->middleware('checkLogin','checkPower','checkPower')->group(function(){
    Route::get('index','Admin\AttrController@index');                  //添加视图
    Route::post('add','Admin\AttrController@add');                     //执行添加
    Route::get('show','Admin\AttrController@show');                     //执行添加
});

