<?php

namespace App\ApiModel;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
     //指定表名
     protected $table = 'cart';
     //指定id
     protected $primaryKey = 'cart_id';
     //关闭时间戳
     public $timestamps = false;
     //黑名单
     protected $guarded = [];
}
