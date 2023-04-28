<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2023/2/2
 * Time: 16:42
 */

namespace app\model;

use think\Model;

class UserBill extends Model
{
    protected $autoWriteTimestamp = false;
    // 设置字段信息
    protected $schema = [
        'id'             => 'int',
        'user_id'        => 'int',
        'title'        => 'string',
        'type'     => 'int',
        'money'   => 'decimal',
        'add_time'       => 'datetime',
    ];
    //当月消费检查
    public static function billCheck($userid){
        $bill=UserBill::where('user_id',$userid)->whereMonth('add_time')->sum('money');
        return $bill;
    }
}