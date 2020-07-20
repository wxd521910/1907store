<?php

namespace App\Exceptions;

use Exception;

class ApiException extends Exception
{
//    //自定义异常处理
//    public function render($request){
//         // return response()->json(['error'=>10001,'msg'=>$this->message],$this->code);
//         $key = $this->message;
//         $msy = config("exception.$key");
//         return response()->json(['code'=>$msy['code'],'msg'=>$msy['msg']],$msy['status']);
//     }

    //自定义异常处理
    public function SetErrorMessage($errorMsg='', $errorCode = '500'){
        $this->errorMsg = $errorMsg;
        $this->errorCode = $errorCode;
        return $this;  
    }
}
