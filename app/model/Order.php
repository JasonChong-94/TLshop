<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2022/12/20
 * Time: 16:09
 */
namespace app\model;

use think\Model;

class Order extends Model
{
    protected $autoWriteTimestamp = false;
    // 设置字段信息
    protected $schema = [
        'id'               => 'int',
        'user_id'          => 'int',
        'mer_id'          => 'int',
        'order_no'         => 'string',
        'parent_no'         => 'string',
        'transaction_id'   => 'int',
        'num'              => 'int',
        'total_price'      => 'decimal',
        'postage'          => 'string',
        'pay_price'        => 'decimal',
        'name'             => 'string',
        'phone'            => 'string',
        'address'          => 'string',
        'delivery_name'    => 'string',
        'delivery_code'    => 'string',
        'add_time'         => 'datetime',
        'pay_time'         => 'datetime',
        'remarks'          => 'string',
        'status'           => 'int',
    ];
    //订单关联商品详情
    public function desc(){
        return $this->hasMany(OrderInfo::class,'order_id','id')->field('order_id,num,price,product,attr_values');
    }
    public function user(){
        return $this->hasOne(User::class,'id','user_id')->bind(['nickname']);
    }
    public function searchUserIdAttr($query, $value)
    {
        $query->where('user_id', $value);
    }
    public function searchStatusAttr($query, $value)
    {
        $query->where('status', $value);
    }
    /**
     * 查询订单数据
     * @param array $where
     * @param int $page
     * @return array
     */
    public static function orderInfo($where,$page){
        $cartInfo = Order::field('id,total_price,pay_price,mer_id')
            ->with(['desc'])
            ->where($where)
            ->page($page,5)
            ->select();
        return $cartInfo;
    }
}