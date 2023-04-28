<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2022/12/21
 * Time: 15:45
 */
namespace app\services;
use app\model\Order;
use think\facade\Db;

class OrderService
{
    /**
     * 处理订单结算数据
     * @param array $cartList
     * @return object
     */
    public function handleOrder($user_id,$list,$addr,$remarks,$parent_no=''){
        $order_no=date('YmdHis').str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
        $total=0;
        foreach ($list as $value){
            $total+=$value['num']*$value['price'];
            $orderInfo[]=[
                'product_id'=>$value['id'],
                'mer_id'=>$value['mer_id'],
                'num'=>$value['num'],
                'product'=>$value['product'],
                'attr_values'=>$value['suk'],
                'price'=>$value['price'],
            ];
        }
        // 启动事务
        Db::startTrans();
        try {
            $orders  = new Order();
            $order=[
                'order_no'=>$order_no,
                'parent_no'=>$parent_no,
                'user_id'=>$user_id,
                'mer_id'=>$list[0]['mer_id'],
                'total_price'=>$total,
                'postage'=>0,
                'pay_price'=>$total,
                'name'=>$addr['name'],
                'phone'=>$addr['phone'],
                'address'=>$addr['province'].$addr['city'].$addr['district'].$addr['addr'],
                'add_time'=>date('Y-m-d H:i:s',time()),
                'remarks'=>$remarks,
                'status'=>10
            ];
            $orders->save($order);
            $order_info = Order::find($orders->id);
            $order_info->desc()->saveAll($orderInfo);
            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            echo $e->getMessage();die;
        }

        return $orders;
    }
    public function callback(){
        //微信回调
        //积分到账 消费积分  分销积分
    }
}