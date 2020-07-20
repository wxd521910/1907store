<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ApiModel\Cart;  //购物车
class CartController extends Controller
{
    // 购物车列表页面
    public function goodsCart(){
        $userList = session('userList');
        if(!$userList){
            echo "<script>alert('请先登陆');location.href='/login/login'</script>";
        }
        $user_id = $userList['user_id'];
        $url = env('INDEX.URL')."api/Index/CartList?user_id=$user_id";
        $CartList=curl($url);
        $CartList=json_decode($CartList,true);
        
        return view('index.cart.cart',['CartList'=>$CartList]);
    }

    //ajax添加购物车
    public function ajaxCart(){
        $buy_num = request()->buy_num;
        $goods_id = request()->goods_id;
        $goods_attr_id = request()->goods_attr_id;
        $userList = session('userList');
        $user_id = $userList['user_id'];
        $userToken = $userList['userToken'];
        $userTokenExpire = $userList['userTokenExpire'];
        $url = env('INDEX.URL')."api/Index/CartCar?user_id=$user_id&userToken=$userToken&userTokenExpire=$userTokenExpire&buy_num=$buy_num&goods_id=$goods_id&goods_attr_id=$goods_attr_id";
        $CartAttr=curl($url);
        $CartAttrs=json_decode($CartAttr,true);
        return $CartAttrs;
    }
    
    // 加号+文本框的值
    public function changeNum(){
        $buy_num = request()->buy_num;
        $cart_id = request()->cart_id;
        if(!$buy_num || !$cart_id){
            return response()->json(['error'=>'0','msg'=>'非法操作']);
        }
        //根据商品id 属性值组合查询购物车表 修改购买数量
        $cartData = Cart::where('cart_id',$cart_id)->update(['buy_num'=>$buy_num]);
        if(!$cartData){
            return response()->json(['error'=>'0','msg'=>'修改数量失败！']);
        }
        return response()->json(['error'=>'200','msg'=>'修改数量成功',]);
    }

    // 小计
    public function getTotal(){
        $cart_id = request()->cart_id;
        if(!$cart_id){
            return response()->json(['error'=>'0','msg'=>'非法操作']);
        }
        //根据购物车id查询商品数量 和价钱
        $cartInfo = Cart::where('cart_id',$cart_id)->first()->toArray();
        $total = $cartInfo['buy_num'] * $cartInfo['add_price'];
        if(!$total){
            return response()->json(['error'=>'0','msg'=>'获取小计失败']);
        }
        return $total;
    }

    // 总价
    public function getTotalCount(){
        $cart_id = request()->cart_id;
        if(!$cart_id){
            return response()->json(['error'=>'0','msg'=>'非法操作']);
        }
        $cart_id = explode(',',$cart_id);

        //根据购物车id whereIn查询购物车商品数据
        $cartInfo = Cart::whereIn('cart_id',$cart_id)
                            ->select('buy_num','add_price')
                            ->get()
                            ->toArray();

        $totalCount = 0;
        foreach($cartInfo as $key=>$value){
            $totalCount += $value['buy_num'] * $value['add_price'];
        }

        return response()->json(['error'=>'200','msg'=>'ok','data'=>$totalCount]);
       
    }

    // 删除
    public function delCart(){
        $cart_id = request()->cart_id;
        if(!$cart_id){
            return response()->json(['error'=>'0','msg'=>'非法操作']);
        }
        $cart_id = explode(',',$cart_id);
        $cartDel =  Cart::whereIn('cart_id',$cart_id)->update(['is_del'=>2]);
        if(!$cartDel){
            return response()->json(['error'=>'0','msg'=>'删除失败！']);
        }
        return response()->json(['error'=>'200','msg'=>'删除成功']);
    }
}
