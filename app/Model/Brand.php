<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
     //指定表名
     protected $table = 'brand';
     //指定id
     protected $primaryKey = 'brand_id';
     //关闭时间戳
     public $timestamps = false;
     //黑名单
     protected $guarded = [];
}
