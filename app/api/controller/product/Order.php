<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2022/12/12
 * Time: 16:22
 */

namespace app\api\controller\product;

use app\BaseController;
use app\model\Cart as CartModel;
use app\model\Order as OrderModel;
use app\model\UserAddress;
use app\services\CartService;
use app\services\OrderService;

class Order extends BaseController
{

    public function create(){
        $addr_id=$this->request->param('addr_id');
        $remarks=$this->request->param('remarks');
        $user_id=$this->request->uid;
        if(!$addr_id){
            return $this->fail(2002);
        }

        //获取购物车状态1的个人数据
        $map[] = ['user_id','=',$this->request->uid];
        $map[] = ['status','=',1];
        $cartInfo=CartModel::cartInfo($map);
        if($cartInfo->isEmpty()){
            return $this->fail(3001);
        }
        /** @var CartService $cartService */
        $cartService=app()->make(CartService::class);
        $list=$cartService->cartMerList($cartInfo);
        if(isset($list['msg'])){
            return json(['msg'=>$list['msg'],'code'=>2001]);
        }
        //获取地址
        $addr=UserAddress::find($addr_id);
        if(!$addr){
            return $this->fail(4001);
        }
        //处理订单 多商家进行拆单
        /** @var OrderService $orderService */
        $orderService=app()->make(OrderService::class);
        $parent_no='';
        if(count($list)>1){
            $parent_no=date('YmdHis').str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
        }
        $total=0;
        foreach ($list as $key=>$value){
            $order=$orderService->handleOrder($user_id,$list[$key],$addr,$remarks,$parent_no);
            $total+=$order['total_price'];
        }
        //接入支付
        //删除购物车
//        CartModel::where($map)->delete();
        CartModel::where($map)
            ->update(['status' => 2]);
        return json($order);
    }
    public function list(){
        $status=$this->request->param('status');
        $page=$this->request->param('page',1);
        $map[] = ['user_id','=',$this->request->uid];
        $map[] = ['status','=',$status];
        $data=OrderModel::orderInfo($map,$page);
        return $this->success($data);
    }

}
