<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2023/2/9
 * Time: 15:58
 */
namespace app\model;

use think\Model;

class AdminMenu extends Model
{
    protected $autoWriteTimestamp = false;
    protected $schema = [
        'id'            => 'int',
        'parent_id'        => 'int',
        'title'      => 'string',
        'uri'        => 'string',
    ];
}