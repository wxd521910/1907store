<?php
    // 无限极分类
    function getclassify($data , $parent_id=0 , $level=1){
        // 定义一个静态的容器
        static $rongqi = [];
        //判断查询的数据是否为空，如果要是为空的话直接返回
        if(!$data){
            return;
        }
        // 进行循环
        foreach($data as $k=>$v){
            // 判断一下，$v->parent_id是否等于parent_id
            if($v->parent_id == $parent_id){
                // 添加一个level
                $v->level = $level;
                // 把添加那个放进那个容器里面
                $rongqi[] = $v;
                // 查询时否满足条件
                getclassify($data , $v->class_id , $level+1);
            }
        }
        // 返回数据
        return $rongqi;
    }

    // 权限--无限极分类 
    function getPowerInfo($cateinfo,$parent_id=0,$level=0){
        static $info=[];
        foreach($cateinfo as $k=>$v){
            if($v['parent_id']==$parent_id){
                $v['level']=$level;
                $info[]=$v;
                getPowerInfo($cateinfo,$v['power_id'],$v['level']+1);
            }
        }
        return $info;
    }

    //权限--递归
    function CreatPower($data,$parent_id=0){
        $new_arr=[];
        foreach($data as $k=>$v){
            if($v['parent_id']==$parent_id){
                $new_arr[$k]=$v;
                $new_arr[$k]['child']=CreatPower($data,$v['power_id']);
            }
        }
        return $new_arr;
    }

    // 单文件上传
    function unifile($log){
        // 判断文件是否在接收的工程中出现错误
        if(request()->file($log)->isValid()){
            //接收文件
            $log = request()->file($log);
            // 上传文件，将文件添到那个文件夹中
            $store_result = $log->store('upoads');
            // 返回值
            return $store_result;
        }
        // 如果上传错误的话就终止
        exit('没有文件被上传或者上传错误');
    }

    // 左测导航
    function navigation(){
        $res = session('admin.power');
        $data = CreatPower($res);
        return $data;
    }

    // 多文件
    function uploads($goods_logs){
        // 判断是否有值，没值的话返回
        if(!$goods_logs){
            return;
        }
        // 接收相册的字段
        $goods_logs = request()->file($goods_logs);
        // 给一个数组
        $where = [];
        foreach($goods_logs as $v){
            $where[] = $v->store('upoads');
        }
      
        return $where;
    }

    // 订单号
    function goodshao(){
        $akk = date('YmdHis') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
        return $akk;
    }

    //curl执行方法
    function curl($url,$type='get',$data=[]){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url); //设置请求地址
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 返回数据格式原生
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//关闭https验证
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);//关闭https验证
        if($type=='post'){
            curl_setopt($curl, CURLOPT_POST, 1);//设置post方式提交
            curl_setopt($curl, CURLOPT_POSTFIELDS,$data);   
        } 
        $output = curl_exec($curl); //执行curl
        curl_close($curl); //关闭curl请求
        return $output; //返回结果
    }

    //通过父级id查询子级id
    function class_id($classInfo,$class_id){
        static $class_id_array=[];
        $class_id_array[]=$class_id;
        foreach($classInfo as $v){
            if($v['parent_id']==$class_id){
                $class_id_array[]=$v['class_id'];
                class_id($classInfo,$v['class_id']);
            }
        }
        return $class_id_array;
    }

    //检测用户是否登陆
    function userLogin(){
        return request()->session()->get('user');
    }

    //获取用户id
    function userId(){
        return request()->session()->get('user');
    }
?>