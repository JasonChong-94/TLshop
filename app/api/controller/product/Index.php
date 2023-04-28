<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2022/12/3
 * Time: 14:46
 */
namespace app\api\controller\product;

use app\BaseController;
use app\model\Product;
use app\model\ProductDesc;

class Index extends BaseController
{

    public function index()
    {
        $id=$this->request->param('id');
        if(!$id){
            return $this->fail(2002);
        }
        $data['product']=Product::field('id,cate_id,name,describe,keyword,price,vip_price,images')
            ->find($id);
        $data['reply']=$data['product']->reply()->withSearch(['status'], [
            'status'			=>	1,
        ])
            ->field('score,comment,images')
            ->order('score','desc')
            ->limit(2)
            ->select();
        $data['attr']=$data['product']->attr()->select();
        return $this->success($data);
    }
    public function detail(){
//        $data=Product::description($this->request->param('id'));
        $data=ProductDesc::where('product_id',$this->request->param('id'))->find();
        return $this->success($data);
    }
}