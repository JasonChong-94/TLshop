<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2023/4/19
 * Time: 11:43
 */
namespace app\admin\controller;

use \app\model\ProductReply;
use app\BaseController;

class Reply extends BaseController
{
    public function list()
    {
        $status=$this->request->param('status');
        $product_id=$this->request->param('product_id');
        $search=[];
        $where=[];
        if($product_id){
            array_push($search,'product_id');
            $where['product_id']=$product_id;
        }
        if($status !=null){
            array_push($search,'status');
            $where['status']=$status;
        }
        $data=ProductReply::withSearch($search,$where)
            ->paginate(10);
        return $this->success($data);
    }

}