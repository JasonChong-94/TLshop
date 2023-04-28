<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2022/12/14
 * Time: 14:57
 */
namespace app\model;

use think\Model;

class ProductAttrVal extends Model
{
    protected $autoWriteTimestamp = false;
    protected $schema = [
        'id'          => 'int',
        'product_id'          => 'int',
        'suk'        => 'string',
        'stock'        => 'int',
        'sales'        => 'int',
        'price'        => 'decimal',
        'vip_price'        => 'decimal',
        'cos_price'        => 'decimal',
        'image'        => 'string',
    ];
}