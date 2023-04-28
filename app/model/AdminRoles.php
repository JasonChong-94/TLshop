<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2023/2/9
 * Time: 15:59
 */
namespace app\model;

use think\Model;

class AdminRoles extends Model
{
//    protected $autoWriteTimestamp = false;
    protected $schema = [
        'id'            => 'string',
        'name'        => 'int',
        'create_time'    => 'datetime',
        'update_time'    => 'datetime',
    ];
    public function menu()
    {
        return $this->belongsToMany(AdminMenu::class, AdminRoleMenu::class,'menu_id','role_id');
    }
}