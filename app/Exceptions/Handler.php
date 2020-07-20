<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        // 接口
        if ($request->is('api/*')) {
            // 异常类
            if ($exception  instanceof   \APP\Exceptions\ApiException){
                $result = [
                "error"=>$exception->errorCode,
                "msg"    => $exception->errorMsg,
            ];
            // JSON_UNESCAPED_UNICODE 不加密文字
                return response()->json($result,200,[],JSON_UNESCAPED_UNICODE);
            }
        }
        return parent::render($request, $exception);
    }
}
