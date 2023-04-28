<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2022/12/8
 * Time: 16:44
 */
namespace app\model;

use think\Model;

class Cart extends Model
{
    protected $autoWriteTimestamp = false;
    // 设置字段信息
    protected $schema = [
        'id'             => 'int',
        'user_id'        => 'int',
        'product'        => 'string',
        'product_id'     => 'int',
        'mer_id'     => 'int',
        'product_attr'   => 'string',
        'add_time'       => 'datetime',
        'num'            => 'int',
        'status'         => 'int',
    ];
    //购物车关联商品详情
    public function productInfo(){
        return $this->hasOne(Product::class,'id','product_id');
    }
    //购物车关联商品规格
    public function attrInfo(){
        return $this->hasOne(ProductAttrVal::class,'id','attr_val_id');
    }
    public function searchUserIdAttr($query, $value)
    {
        $query->where('user_id', $value);
    }
    /**
     * 查询购物车数据
     * @param array $where
     * @return array
     */
    public static function cartInfo($where){
        $cartInfo=Cart::field('id,product,num,mer_id')
            ->withJoin([
                'attrInfo'=>['id','suk','stock','price','vip_price'],
                'productInfo'=>['id','stock','price','vip_price']
            ],'LEFT')
            ->where($where)
            ->select();
        return $cartInfo;
    }
}