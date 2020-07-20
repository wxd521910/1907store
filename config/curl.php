<?php
/*
 * @Author: your name
 * @Date: 2020-04-30 15:57:14
 * @LastEditTime: 2020-04-30 16:08:24
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \shop\config\curl.php
 */

class MyCurl{
   
    private $ch;
   
    //构造函数----开始
    public function __construct()
    {
         $this->ch=curl_init(); 
    }
    //析构函数----结束
    public function __destruct()
    {
      curl_close($this->ch);
    }

    //get方式
    public function curlGet($url){ 
    //设置URL和相应的选项
    curl_setopt($this->ch,CURLOPT_URL,$url);
    curl_setopt($this->ch,CURLOPT_RETURNTRANSFER,1); 
    }

    //post方式
    public function curlPost($data){
      //创建一个新cURL资源
      //$ch = curl_init();
      curl_setopt($this->ch,CURLOPT_POST,1);//post 方式
      curl_setopt($this->ch,CURLOPT_POSTFIELDS,$data);
      //忽略证书
      curl_setopt($this->ch,CURLOPT_SSL_VERIFYPEER,false);
      curl_setopt($this->ch,CURLOPT_SSL_VERIFYHOST,false);
      //忽略头信息
      curl_setopt($this->ch,CURLOPT_HEADER,0);
      //设置超时时间 10 秒
      curl_setopt($this->ch,CURLOPT_TIMEOUT ,10);
   }


    public function exec($url,$func='get',$data=''){
        $this->curlGet($url);
        if($func=='post'){
            $this->curlPost($data);
        }
       //抓取URL并把它传递给浏览器
        $output=curl_exec($this->ch);
        if($out_error=curl_error($this->ch)){
            return ['error'=>'yes','ouput'=>$out_error];   
        }
        return ['error'=>'no','ouput'=>$output];
    }
}

?>