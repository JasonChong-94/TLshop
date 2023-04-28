<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2022/11/30
 * Time: 15:04
 */
namespace app\model;

use think\Model;

class Article extends Model
{
    protected $autoWriteTimestamp = false;
    // 设置字段信息
    protected $schema = [
        'id'             => 'int',
        'title'        => 'string',
        'describe'        => 'text',
        'path'     => 'string',
        'image'     => 'string',
        'block'     => 'int',
        'type'     => 'int',
        'status'     => 'int',
    ];
    public function searchStatusAttr($query, $value, $data)
    {
        $query->where('status', $value);
    }
    public function searchBlockAttr($query, $value, $data)
    {
        $query->where('block', $value);
    }
}