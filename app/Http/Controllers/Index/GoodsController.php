<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ApiModel\Goods;         //商品
use APP\ApiModel\GoodsAttr;       //商品属性
use App\ApiModel\GoodsSku;      //sku表
use App\ApiModel\Cart;          //购物车
use Illuminate\Support\Facades\Cache;    //缓存类

class GoodsController extends Controller{
    //商品详情展示
    public function goodsInfo(){
        $goods_id=request()->goods_id;
        $url=env('INDEX.URL')."api/Index/goodsInfo/?goods_id=$goods_id";
        $goodsInfo=curl($url);
        $goodsInfo=json_decode($goodsInfo, true);
        $goodsInfo['data']['goods']['goods_logs']=explode('|', $goodsInfo['data']['goods']['goods_logs']);
        return view('index.goods.goodsInfo',['goodsInfo'=>$goodsInfo]);
    }

    
     //商品详情展示    //  public function goodsInfo(){
    //     $goods_id=request()->goods_id;
    //     if (Cache::has($goods_id)){    //首先查寻cache如果找到
    //         $values = Cache::get($goods_id); //直接读取cache
    //         return $values;
    //     }else{         //如果cache里面没有  
    //         $url=env('INDEX.URL')."api/Index/goodsInfo/?goods_id=$goods_id";
    //         $goodsInfo=curl($url);
    //         $goodsInfo=json_decode($goodsInfo, true);
    //         $goodsInfo['data']['goods']['goods_logs']=explode('|', $goodsInfo['data']['goods']['goods_logs']);
    //         Cache::put($goods_id,$goodsInfo,200);
    //         return $values;
    //     }

       
       
    //     return view('index.goods.goodsInfo',['goodsInfo'=>$goodsInfo]);
    // }


    // 商品详情点击相加价钱
    public function goodsPrice(){
        $goods_attr_id = request()->goods_attr_id;
        $url = env('INDEX.URL')."api/Index/goodsPrice?goods_attr_id=$goods_attr_id";
        $goodsAttr=curl($url);
        $goodsAttr=json_decode($goodsAttr,true);
        return $goodsAttr;
    }
    
}
