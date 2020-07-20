<?php

namespace App\ApiModel;

use Illuminate\Database\Eloquent\Model;

class Goods_Sku extends Model
{
    //指定表名
    protected $table = 'goods_sku';
    //指定id
    protected $primaryKey = 'goods_sku_id';
    //关闭时间戳
    public $timestamps = false;
    //黑名单
    protected $guarded = [];
}
