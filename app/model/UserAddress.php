<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2022/12/13
 * Time: 17:04
 */
namespace app\model;

use think\Model;

class UserAddress extends Model
{
//    protected $autoWriteTimestamp = false;
    protected $schema = [
        'id'          => 'int',
        'user_id'     => 'int',
        'name'        => 'string',
        'phone'       => 'string',
        'province'    => 'string',
        'city'        => 'string',
        'district'    => 'string',
        'addr'        => 'string',
        'default'     => 'int',
    ];
    public function searchNameAttr($query, $value)
    {
        $query->where('name','like', $value . '%');
    }
    //修改原默认地址
    public static function editDefault($uid)
    {
        return UserAddress::where('user_id', $uid)->where('default', 1)->update(['default' => 0]);
    }
}