<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2023/4/15
 * Time: 15:47
 */
namespace app\model;

use think\Model;

class UserExtract extends Model
{
    protected $autoWriteTimestamp = false;
    // 设置字段信息
    protected $schema = [
        'id'             => 'int',
        'user_id'   => 'int',
        'real_name'   => 'string',
        'way'   => 'int',
        'extract_type'   => 'string',
        'extract_price'   => 'decimal',
        'extract_account'   => 'string',
        'integral'   => 'decimal',
        'remarks'   => 'string',
        'status'   => 'string',
        'msg'   => 'string',
        'add_time'   => 'datetime',
    ];
}