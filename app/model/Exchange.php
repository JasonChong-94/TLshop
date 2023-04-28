<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2023/4/12
 * Time: 16:51
 */
namespace app\model;

use think\Model;

class Exchange extends Model
{
    protected $autoWriteTimestamp = false;
    // 设置字段信息
    protected $schema = [
        'id'             => 'int',
        'product_id'   => 'int',
        'mer_id'   => 'int',
        'image'   => 'string',
        'images'   => 'string',
        'name'   => 'string',
        'price'   => 'decimal',
        'stock'   => 'int',
        'ex_integral'   => 'int',
        'status'   => 'string',
    ];
    public function desc()
    {
        return $this->hasOne(ProductDesc::class,'product_id','product_id')->bind(['description']);
    }
    /**
     * 商品名搜索器
     * @param Model $query
     * @param $value
     */
    public function searchNameAttr($query, $value)
    {
        $query->where('name','like', '%' . $value . '%');
    }
}