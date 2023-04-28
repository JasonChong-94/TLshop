<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2022/12/6
 * Time: 17:38
 */
namespace app\model;

use think\Model;

class ProductAttr extends Model
{
    protected $autoWriteTimestamp = false;
    // 设置字段信息
    protected $schema = [
        'id'             => 'int',
        'product_id'          => 'int',
        'attr_name'        => 'string',
        'attr_values'        => 'string',
    ];
}