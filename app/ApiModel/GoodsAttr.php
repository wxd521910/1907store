<?php

namespace App\ApiModel;

use Illuminate\Database\Eloquent\Model;

class GoodsAttr extends Model
{
    //指定表名
    protected $table = 'goodsattr';
    //指定id
    protected $primaryKey = 'goods_attr_id';
    //关闭时间戳
    public $timestamps = false;
    //黑名单
    protected $guarded = [];
}
