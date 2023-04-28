<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2023/2/9
 * Time: 15:58
 */
namespace app\model;

use think\model\Pivot;
class AdminRoleMenu extends Pivot
{
//    protected $autoWriteTimestamp = false;
    protected $schema = [
        'role_id'            => 'int',
        'menu_id'        => 'int',
        'create_time'    => 'datetime',
        'update_time'    => 'datetime',
    ];
    public function searchRoleIdAttr($query, $value)
    {
        $query->where('role_id',$value);
    }
}