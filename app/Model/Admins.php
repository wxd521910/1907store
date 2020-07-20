<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Admins extends Model
{
      //指定表名
      protected $table = 'admins';
      //指定id
      protected $primaryKey = 'admins_id';
      //关闭时间戳
      public $timestamps = false;
      //黑名单
      protected $guarded = [];
}
