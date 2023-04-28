<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2023/4/13
 * Time: 16:30
 */
namespace app\api\controller\product;

use app\BaseController;
use app\model\ProductDesc;
use app\services\GoodsService;

class Exchange extends BaseController
{

    public function index()
    {
        $page=$this->request->param('page',1);
        $where[] = ['status','=',1];
        $field='id,name,price,image,images,stock,ex_integral';
        $result=app()->make(GoodsService::class);
        $data=$result->getExList($where,$field,$page);
        return $this->success($data);
    }
    public function detail(){
//        $data=Product::description($this->request->param('id'));
        $data=ProductDesc::where('product_id',$this->request->param('id'))->find();
        return $this->success($data);
    }
}