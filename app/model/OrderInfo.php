<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2022/12/20
 * Time: 16:12
 */
namespace app\model;
use think\Model;

class OrderInfo extends Model
{
    protected $autoWriteTimestamp = false;
    // 设置字段信息
    protected $schema = [
        'id'            => 'int',
        'order_id'      => 'int',
        'mer_id'      => 'int',
        'product'       => 'string',
        'product_id'    => 'int',
        'num'           => 'int',
        'attr_values'   => 'string',
        'price'         => 'decimal',
    ];
}