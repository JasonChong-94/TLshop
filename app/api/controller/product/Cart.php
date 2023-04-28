<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2022/12/8
 * Time: 16:37
 */
namespace app\api\controller\product;

use app\BaseController;
use app\model\Cart as CartModel;
use app\services\CartService;

class Cart extends BaseController
{

    public function index()
    {
        $map[] = ['user_id','=',$this->request->uid];
        $map[] = ['status','=',0];
        $data=CartModel::cartInfo($map);
        if($data->isEmpty()){
            return $this->fail(3001);
        }
        /** @var CartService $service */
        $service=app()->make(CartService::class);
        $list=$service->cartList($data);
        return $this->success($list);
    }

    public function add()
    {
        $validate = new \app\api\validate\Cart();
        $result = $validate->check($this->request->all());

        if(!$result){
            return json(['msg'=>$validate->getError(),'code'=>2002]);
        }
        $user = new CartModel;
        $user->user_id=$this->request->uid;
        $user->save($this->request->all());
        return $this->success($this->request->all());

    }
    public function update()
    {
        $id=$this->request->param('id');
        $num=$this->request->param('num');
        if(!$id ||!$num)return $this->fail(2002);
        $user = CartModel::find($id);
        $user->num     = $num;
        $user->save();
        return $this->tips(2000);

    }
    public function del()
    {
        $id=$this->request->param('ids');
        if(!$id)return $this->fail(2001);
        $ids=explode(',',$id);
        CartModel::destroy($ids);
        return $this->tips(2000);
    }
    //购物车结算
    public function confirm(){
        $cart_ids=$this->request->param('cart_ids');
        //通过购物车id获取对应商品
        $ids=explode(',',$cart_ids);
        $map[] = ['tl_cart.id','in',$ids];
        $shopinfo=CartModel::cartInfo($map);
//        $shopinfo = CartModel::cartInfo($ids);
        if($shopinfo->isEmpty()){
            return $this->fail(30001);
        }
        /** @var CartService $service */
        $service=app()->make(CartService::class);
        $list=$service->handleCartList($shopinfo);
        if(isset($list['msg'])){
            return json(['msg'=>$list['msg'],'code'=>2001]);
        }
        //更改购物车状态
        CartModel::where('id','in',$ids)
            ->update(['status' => 1]);
        return $this->success($list);
    }
    public function recommend(){
        /** @var CartService $service */
        $service=app()->make(CartService::class);
        $list=$service->recommend($this->request->uid);
        return $this->success($list);
    }
}