<?php
/**
 * Created by PhpStorm.
 * UserController: 联想
 * Date: 2022/11/22
 * Time: 14:58
 */

namespace app\model;

use think\Model;

class User extends Model
{
//    protected $autoWriteTimestamp = false;
    protected $schema = [
        'id'            => 'int',
        'openid'        => 'string',
        'nickname'      => 'string',
        'account'      => 'string',
        'avatar'        => 'string',
        'pwd'           => 'string',
        'phone'         => 'string',
        'spend_money'   => 'decimal',
        'package'       => 'decimal',
        'spend_integral'      => 'int',
        'invite_integral'      => 'int',
        'invite_code'   => 'string',
        'invite_uid'    => 'int',
        'level'         => 'int',
        'create_time'    => 'datetime',
        'update_time'    => 'datetime',
    ];
    //隐藏字段
    protected $hidden=['pwd','openid'];
    public function address(){
        return $this->hasMany(UserAddress::class,'user_id','id');
    }
    public function searchNickNameAttr($query, $value, $data)
    {
        $query->where('nickname','like', $value . '%');
    }

    public function searchCreateTimeAttr($query, $value, $data)
    {
        $query->whereBetweenTime('create_time', $value[0], $value[1]);
    }
    public function searchAccountAttr($query, $value)
    {
        $query->where('account',$value);
    }
    public function searchPwdAttr($query, $value)
    {
        $query->where('pwd', $value);
    }
    public function searchInviteUidAttr($query, $value)
    {
        $query->where('invite_uid', $value);
    }
}