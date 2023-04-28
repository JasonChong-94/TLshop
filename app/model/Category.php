<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2022/11/30
 * Time: 11:44
 */
namespace app\model;

use think\Db;
use think\Model;

class Category extends Model
{
    protected $autoWriteTimestamp = false;
    protected $schema = [
        'id'             => 'int',
        'cate_name'        => 'string',
        'pid'     => 'int',
        'sort'   => 'int',
        'image'       => 'string',
    ];
    public function searchPidAttr($query, $value, $data)
    {
        $query->where('pid', $value);
        if (isset($data['sort'])) {
            $query->order($data['sort']);
        }
    }
    public function searchCateNameAttr($query, $value, $data)
    {
        $query->where('cate_name', $value);
        if (isset($data['sort'])) {
            $query->order($data['sort']);
        }
    }
    public function searchCateIdAttr($query, $value, $data)
    {
        $query->where('pid', $value);
    }
}