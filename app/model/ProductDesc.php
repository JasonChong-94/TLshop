<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2022/12/8
 * Time: 14:11
 */
namespace app\model;

use think\Model;

class ProductDesc extends Model
{
    protected $autoWriteTimestamp = false;
    // 设置字段信息
    protected $schema = [
        'product_id'             => 'int',
        'description'   => 'string',
    ];
}