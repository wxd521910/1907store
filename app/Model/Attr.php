<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Attr extends Model
{
       //指定表名
       protected $table = 'attr';
       //指定id
       protected $primaryKey = 'attr_id';
       //关闭时间戳
       public $timestamps = false;
       //黑名单
       protected $guarded = [];
}
