<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2022/12/7
 * Time: 15:40
 */
namespace app\model;

use think\Model;

class ProductReply extends Model
{
    protected $autoWriteTimestamp = false;
    // 设置字段信息
    protected $schema = [
        'id'          => 'int',
        'product_id'          => 'int',
        'user_id'          => 'int',
        'order_id'          => 'int',
        'score'        => 'float',
        'comment'        => 'string',
        'images'        => 'string',
        'add_time'        => 'datetime',
        'nickname'        => 'string',
        'avatar'        => 'string',
        'status'        => 'int',
    ];
    public function searchStatusAttr($query, $value, $data)
    {
        $query->where('status', $value);
    }
    public function searchProductIdAttr($query, $value, $data)
    {
        $query->where('product_id', $value);
    }
}