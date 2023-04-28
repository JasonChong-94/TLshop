<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2023/4/12
 * Time: 16:48
 */
namespace app\admin\controller;

use app\admin\validate\ExchangeValidate;
use app\services\GoodsService;
use app\BaseController;

class Exchange extends BaseController
{

    //列表显示
    public function index()
    {
        $name=$this->request->param('name');
        $search=[];
        $where=[];
        $field='id,name,price,image,images,stock,ex_integral';
        if($name){
            array_push($search,'name');
            $where['name']=$name;
        }
        /** @var GoodsService $result */
        $result=app()->make(GoodsService::class);
        $list=$result->exList($search,$where,$field);
        return $this->success($list);
    }
    public function create(ExchangeValidate $validate){
        $result=$validate->check($this->request->all());
        if(!$result){
            return $this->fail($validate->getError());
        }
        /** @var GoodsService $service */
        $service=app()->make(GoodsService::class);
        $res=$service->exCreate($this->request->all());
        if($res) return $this->tips(2000);
        return $this->fail();
    }
    public function update(ExchangeValidate $validate){
        $result=$validate->sceneEdit()->check($this->request->all());
        if(!$result){
            return $this->fail($validate->getError());
        }
        /** @var GoodsService $service */
        $service=app()->make(GoodsService::class);
        $res=$service->exUpdate($this->request->all());
        if($res) return $this->tips(2000);
        return $this->fail();
    }
}