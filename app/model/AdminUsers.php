<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2023/2/8
 * Time: 17:03
 */
namespace app\model;

use think\Model;

class AdminUsers extends Model
{
    protected $autoWriteTimestamp = true;
    protected $schema = [
        'id'            => 'int',
        'account'        => 'string',
        'password'      => 'string',
        'name'        => 'string',
        'avatar'           => 'string',
        'create_time'    => 'datetime',
        'update_time'    => 'datetime',
    ];
    public function setPasswordAttr($value)
    {
        return md5($value);
    }
    public function searchPasswordAttr($query, $value)
    {
        $query->where('password', $value);
    }
    public function roles()
    {
        return $this->belongsToMany(AdminRoles::class, AdminRoleUsers::class,'role_id','user_id');
    }
    public static function roleId($id){
        $role_id=AdminRoleUsers::where('user_id',$id)->column('role_id');
        return $role_id;
    }
}