<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
     //指定表名
     protected $table = 'type';
     //指定id
     protected $primaryKey = 'type_id';
     //关闭时间戳
     public $timestamps = false;
     //黑名单
     protected $guarded = [];
}
