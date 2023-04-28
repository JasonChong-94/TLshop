<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2023/3/8
 * Time: 16:42
 */
namespace app\model;

use think\Model;

class Config extends Model
{
    protected $autoWriteTimestamp = false;
    // 设置字段信息
    protected $schema = [
        'id'             => 'int',
        'type'        => 'int',
        'info'        => 'string',
        'name'        => 'string',
        'value'     => 'text',
    ];
}