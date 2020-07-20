<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    //指定表名
    protected $table = 'area';
    //指定id
    protected $primaryKey = 'id';
    //关闭时间戳
    public $timestamps = false;
    //黑名单
    protected $guarded = [];
}
