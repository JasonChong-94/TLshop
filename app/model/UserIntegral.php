<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2023/4/15
 * Time: 14:29
 */
namespace app\model;

use think\Model;

class UserIntegral extends Model
{
    protected $autoWriteTimestamp = false;
    // 设置字段信息
    protected $schema = [
        'id'             => 'int',
        'user_id'   => 'int',
        'title'   => 'string',
        'money'   => 'decimal',
        'integral'   => 'decimal',
        'type'   => 'string',
        'time'   => 'datetime',
    ];
}