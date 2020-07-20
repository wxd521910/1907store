<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ApiModel\Goods as goodsModel;//商品
use App\ApiModel\GoodsAttr;//属性
use App\ApiModel\Users; //用户
use App\ApiModel\Cart;     //加入购物车
use App\ApiModel\Goods_Sku as GoodsSku; //sku
use Illuminate\Support\Facades\Cache;     //缓存类
class Goods extends Controller{
    
    //商品详情接口
    public function goodsInfo(){
        $goods_id=request()->goods_id;
        if(empty($goods_id) ){
            throw (new ApiException)->SetErrorMessage('没有参数',10001);
        }
        $goodsSku=GoodsAttr::join('attr','attr.attr_id','=','goodsattr.attr_id')
                            ->where('goodsattr.goods_id','=',$goods_id)
                            ->get()->toArray();
        $args  = $spec = [];
        foreach ($goodsSku as $k=>$v){
            if($v['attr_type']==1){
                    // 可选
                    $status = $v['attr_name'];
                    $spec[$status][] = $v;
                  }else{
                    //不可选
                    $status = $v['attr_name'];
                    $args[$status][] = $v;
                  }
        }
        // 商品基本信息
        $goodsData = goodsModel::where('goods_id',$goods_id)->first();
        // 返回数据
        return response()->json([
            'errer' => 200,
            'msg' => 'ok',
            'data'=>[
                'goods' =>$goodsData, //商品基本信息
                'spec' =>$spec, //商品可选
                'args' =>$args, //商品不可选
            ],
        ]);
    }
    
    // ajax点加号价钱
    public function goodsPrice(){
        $goods_attr_id =request()->goods_attr_id;
        if(!$goods_attr_id){
            throw (new ApiException)->SetErrorMessage('参数异常',10001);die;
        }
        $goods_attr_ids = explode(',',$goods_attr_id);
        //根据属性id 获取属性价钱
        $goodsAttr = GoodsAttr::whereIn('goods_attr_id',$goods_attr_ids)
                                ->select('goods_id','attr_price')
                                ->get()
                                ->toArray();
        //循环相加
        $count = 0;
        foreach ($goodsAttr as $k=>$v){
            $count += $v['attr_price'];
        }
        //根据商品ID 获取到商品的基础价钱
        $goods_id = $goodsAttr[$k]['goods_id'];
        $goodsData = goodsModel::where('goods_id',$goods_id)
                                ->first('goods_price')
                                ->toArray();
        //基本价钱加上属性价钱
        $goodsDatas = $goodsData['goods_price'] + $count;
        //获取商品库存
        $goodsSku = GoodsSku::where('goods_attr_id',$goods_attr_id)
                                ->first('goods_num')
                                ->toArray();
        // 异常
        if(!$goodsSku){
            throw (new ApiException)->SetErrorMessage('没有商品组合',10001);
        }
        $data = [
            'goods_price' => $goodsDatas,
            'goodsSku' => $goodsSku
        ];
        //    返回数据
        return $data;
    }
}
