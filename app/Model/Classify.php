<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Classify extends Model
{
      //指定表名
      protected $table = 'classify';
      //指定id
      protected $primaryKey = 'class_id';
      //关闭时间戳
      public $timestamps = false;
      //黑名单
      protected $guarded = [];
}
