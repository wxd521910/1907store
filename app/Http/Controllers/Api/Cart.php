<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ApiModel\Users;
use App\ApiModel\GoodsAttr;
use App\ApiModel\Cart as CartModel;
use App\ApiModel\Goods_Sku as GoodsSku;
use App\ApiModel\Goods;
class Cart extends Controller
{
    // 加入购物车接口
    public function CartCar(){
            /**
             * 用户是否登陆
             * 商品  用户  用户Token  过期时间   商品属性id    要购买的数量
             */
            $goods_id = request()->goods_id;
            $user_id = request()->user_id;
            $goods_attr = request()->goods_attr_id;
            $goods_attr_id=explode(',', $goods_attr);
            $buy_num = request()->buy_num;

            if(empty($goods_id) || empty($user_id) || empty($goods_attr) || empty($buy_num)){
                throw (new ApiException)->SetErrorMessage('参数异常',10001);
            }

            $userData = Users::where('id', '=', $user_id)->first();
            if ($userData['userTokenExpire'] < time()) {
                throw (new ApiException)->SetErrorMessage('登陆过期,清重新登陆',1);
            }
            //获取商品的基本价钱
            $goodsInfo = Goods::where('goods_id',$goods_id)->first()->toArray();  
            $goodsAttr = GoodsAttr::whereIn('goods_attr_id',$goods_attr_id)->get();
            //商品单价+属性价钱的值
            foreach ($goodsAttr as $v){
                $goodsInfo['goods_price'] += $v['attr_price'];
            }
            //单件商品加属性价钱
            $add_price = $goodsInfo['goods_price'];
            // 查看属性是否一样
            // 有则修改没则入库
            $where = [
                ['goods_id','=',$goods_id],
                ['user_id','=',$user_id],
                ['goods_attr_id','=',$goods_attr],
                ['is_del','=',1]
            ];
            $cart=CartModel::where($where)->first();
            if($cart){
                //有则累加
                //检测库存
                $result=$this->checkGoodsNum($buy_num,$goods_attr,$cart['buy_num']);
                if (empty($result)) {
                    throw (new ApiException)->SetErrorMessage('超过最大购买库存',2);
                    // return response()->json(['code'=>'40004','msg'=>'超过最大购买库存']);
                }
                $res=CartModel::where($where)->update(['buy_num'=>$buy_num+$cart['buy_num'],'add_time'=>time(),'add_price'=>$add_price]);
                if(!$res){
                    throw (new ApiException)->SetErrorMessage('添加失败',404);
                }
            }else{
                //检测库存
                $result=$this->checkGoodsNum($buy_num,$goods_attr);
                if(empty($result)) {
                    throw (new ApiException)->SetErrorMessage('超过最大购买库存',2);
                    // return response()->json(['code'=>'40004','msg'=>'超过最大购买库存']);
                }
                //无则添加
                $res=CartModel::create([
                        'goods_id'=>$goods_id,
                        'user_id'=>$user_id,
                        'add_price'=>$add_price,
                        'buy_num'=>$buy_num,
                        'goods_attr_id'=>$goods_attr,
                        'add_time'=>time()
                ]);
            }
            return response()->json([
                'error'=>'200',
                'msg'=>'添加成功',
            ]);
            
    }

    //检测库存
    public function checkGoodsNum($buy_num,$goods_attr,$already_num=0){
        $goods_num=GoodsSku::where('goods_attr_id',$goods_attr)->first()->toArray();
        if($buy_num+$already_num > $goods_num['goods_num']){
            return false;
        }else{
            return true;
        }
    }

    // 购物车列表
    public function CartList(){
        $user_id = request()->user_id;
        if (!$user_id){
            throw (new ApiException())->setErrorMessage('非法操作','14900');
        }
        $where = [
            'user_id'=>$user_id,
            'is_del'=>1
        ];
        //通过user_id 查询用户购物车数据
        $cartInfo = CartModel::join('goods','goods.goods_id','=','cart.goods_id')
                            ->where($where)
                            ->orderBy('cart_id','DESC')
                            ->get()
                            ->toArray();
            
            foreach ($cartInfo as $key => $val ){
                $goods_attr_id = explode(',',$val['goods_attr_id']);
                $cartInfo[$key]['attr_value'] = GoodsAttr::join('attr','attr.attr_id','=','goodsattr.attr_id')
                                                            ->select('attr_name','attr_value')
                                                            ->whereIn('goods_attr_id',$goods_attr_id)
                                                            ->get()
                                                            ->toArray();
            }
            
            foreach ($cartInfo as $k => $v){
                $GoodsSku = GoodsSku::where('goods_attr_id',$v['goods_attr_id'])
                                        ->select('goods_num')
                                        ->get()
                                        ->toArray();
                foreach($GoodsSku as $kk => $vv){
                    $cartInfo[$k]['goods_num'] = $vv['goods_num'];
                }
            }
            return response()->json([
                'cartInfo'=>$cartInfo
            ]);
    }
}
