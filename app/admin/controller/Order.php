<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2023/2/28
 * Time: 15:20
 */
namespace app\admin\controller;

use app\BaseController;
use app\model\Order as OrderModel;
class Order extends BaseController
{

    //列表显示
    public function index()
    {
        $status=$this->request->param('status');
        $search=[];
        $where=[];
//        $field='id,order_no,parent_no,transaction_id,user_id';
        if($status){
            array_push($search,'status');
            $where['status']=$status;
        }
        $data=OrderModel::with(['desc','user'])
            ->withSearch($search,$where)
//            ->field($field)
            ->paginate(10);
        return $this->success($data);
    }
    //发货
    public function delivery(){
        $id=$this->request->param('id');
        $delivery_name=$this->request->param('delivery_name');
        $delivery_code=$this->request->param('delivery_code');
        if(!$id || !$delivery_name || !$delivery_code){
            return $this->fail(2002);
        }
        $order = OrderModel::find($id);
        $order->delivery_name     = $delivery_name;
        $order->delivery_code    = $delivery_code;
        $order->status    = 30;
        $order->save();
        return $this->tips(2000);
    }
}