<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ApiModel\Classify;  
use App\ApiModel\Goods;
class IndexController extends Controller{
    // 首页 
    public function index(){
        // $a = session('userList');
        // dd($a);
        $url = env('INDEX.URL').'api/Index/goodsList';
        $goodInfo=curl($url);
        $goodInfo=json_decode($goodInfo,true);
        $count=Goods::count();
        $cateInfo=Classify::where('class_nav','=',1)->limit(8)->get();
        return view('index.index.index',['goodInfo'=>$goodInfo,'cateInfo'=>$cateInfo,'count'=>$count]);
    }

    // 商品列表
    public function goodsList(){
        $class_id = request()->class_id;
        $url = env('INDEX.URL')."api/Index/goodsList/?class_id=$class_id";
        $goodsList=curl($url);
        $goodsList=json_decode($goodsList,true);
        return view('index.list.list',['goodsList'=>$goodsList]);
    }

    // 分类列表
    public function classIndex(){
        $url = env('INDEX.URL').'api/Index/goodsList';
        $goodInfo=curl($url);
        $goodInfo=json_decode($goodInfo,true);
        $count=Goods::count();
        $cateInfo=Classify::where('class_nav','=',1)->get()->toArray();
        return view('index.class.class',['goodInfo'=>$goodInfo,'cateInfo'=>$cateInfo,'count'=>$count]);
    }

    //点击ajax的分类列表 
    public function goodsCateList(){
        
        //接收传过来的值
        $class_id=request()->class_id;
        
        // $classInfo=Classify::get()->toArray();
        
        // $class_id=class_id($classInfo,$class_id);
        // dd($classInfo);
        // // 移除数组中重复的值
        // $class_id=array_unique($class_id);
        // // 把数组元素组合为字符串
        // $class_id=implode('|',$class_id);
        $url=env('INDEX.URL')."api/Index/goodsList/?class_id=$class_id";
        $goodInfo=curl($url);
        $goodInfo=json_decode($goodInfo,true);
        return $goodInfo;
       
    }
}
