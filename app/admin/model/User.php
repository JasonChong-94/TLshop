<?php
/**
 * Created by PhpStorm.
 * UserController: 联想
 * Date: 2022/11/22
 * Time: 14:58
 */

namespace app\admin\model;

use think\Model;

class User extends Model
{
    public function searchNameAttr($query, $value, $data)
    {
        $query->where('name','like', $value . '%');
    }

    public function searchCreateTimeAttr($query, $value, $data)
    {
        $query->whereBetweenTime('create_time', $value[0], $value[1]);
    }
}