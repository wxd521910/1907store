<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ApiModel\Goods as goodsModel;//商品
use App\ApiModel\Goodsattr; //属性
class Index extends Controller{

    //商品列表接口
    public function goodsList(){
        
        $class_id=request()->class_id;
        if(!empty($class_id)){
            $class_id=explode('|',$class_id);
            $goodsInfo=goodsModel::whereIn('class_id',$class_id)->get()->toArray();
        }else{
            $goodsInfo=goodsModel::orderBy('goods_id','DESC')
                                    ->limit(6)
                                    ->get()
                                    ->toArray();
        }
        return $goodsInfo;
    }
}
