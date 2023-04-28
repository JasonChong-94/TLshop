<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2023/2/9
 * Time: 15:58
 */
namespace app\model;

use think\model\Pivot;
class AdminRoleUsers extends Pivot
{
//    protected $autoWriteTimestamp = false;
    protected $schema = [
        'role_id'            => 'int',
        'user_id'        => 'int',
        'create_time'    => 'datetime',
        'update_time'    => 'datetime',
    ];
    public function searchUserIdAttr($query, $value)
    {
        $query->where('user_id',$value);
    }
}