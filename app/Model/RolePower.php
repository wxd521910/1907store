<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RolePower extends Model
{
    //指定表名
    protected $table = 'role_power';
   
    //关闭时间戳
    public $timestamps = false;
    //黑名单
    protected $guarded = [];
}
