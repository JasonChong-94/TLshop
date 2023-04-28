<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2022/11/30
 * Time: 17:52
 */
namespace app\model;

use think\Model;

class Product extends Model
{
    protected $autoWriteTimestamp = false;
    // 设置字段信息
    protected $schema = [
        'id'             => 'int',
        'name'   => 'string',
        'image'   => 'string',
        'images'   => 'string',
        'category_id'   => 'int',
        'bar_code'   => 'string',
        'describe'   => 'string',
        'spec_type'   => 'int',
        'price'   => 'decimal',
        'cos_price'   => 'decimal',
        'vip_price'   => 'decimal',
//        'ex_integral'   => 'int',
        'stock'   => 'int',
        'unit'   => 'string',
        'weight'   => 'string',
        'logistics'   => 'string',
        'is_show'   => 'int',
    ];
    public function reply()
    {
        return $this->hasMany(ProductReply::class);
    }
    public function attr()
    {
        return $this->hasMany(ProductAttr::class);
    }
    public function attrVal()
    {
        return $this->hasMany(ProductAttrVal::class);
    }
    public function desc()
    {
        return $this->hasOne(ProductDesc::class);
    }
    public function searchIsShowAttr($query, $value, $data)
    {
        $query->where('is_show', $value);
        if (isset($data['sort'])) {
            $query->order($data['sort']);
        }
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
    public function searchIsNewAttr($query, $value)
    {
        $query->where('is_new', $value);
    }
    public function searchIsHotAttr($query, $value)
    {
        $query->where('is_hot', $value);
    }
    public function searchIsBestAttr($query, $value)
    {
        $query->where('is_best', $value);
    }
    public function searchCategoryIdAttr($query, $value)
    {
        $query->where('category_id', $value);
    }
}