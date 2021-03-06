<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Power extends Model
{
    //指定表名
    protected $table = 'power';
    //指定id
    protected $primaryKey = 'power_id';
    //关闭时间戳
    public $timestamps = false;
    //黑名单
    protected $guarded = [];
}
