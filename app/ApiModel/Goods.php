<?php

namespace App\ApiModel;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
     //指定表名
     protected $table = 'goods';
     //指定id
     protected $primaryKey = 'goods_id';
     //关闭时间戳
     public $timestamps = false;
     //黑名单
     protected $guarded = [];
}
