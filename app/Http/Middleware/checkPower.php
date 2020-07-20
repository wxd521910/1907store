<?php

namespace App\Http\Middleware;

use Closure;

class checkPower
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $server_name=$request->path();
        $admin=session('admin');
        //没有权限
        $route=0;
         //所有人都可以看到的url地址
        $allRoute=['Admins/greet'];
        if(in_array($server_name,$allRoute)){
             $route=1;
        }else{
            foreach ($admin['power'] as $k=>$v){
             if($v['url']==$server_name){
               $route=1;
               break;
              }
          }
       }
        if(!$route){
              echo  "<script>alert('您没有此权限');location.href='/Admins/greet'</script>";
              die;
        }
        return $next($request);
    }
}
