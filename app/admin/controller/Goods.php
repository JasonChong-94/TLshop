<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2023/2/11
 * Time: 16:55
 */
namespace app\admin\controller;

use app\admin\validate\ProductValidate;
use app\services\GoodsService;
use app\BaseController;
use app\services\FileService;

class Goods extends BaseController
{

    //列表显示
    public function index()
    {
        $name=$this->request->param('name');
        $is_show=$this->request->param('is_show');
        $search=[];
        $where=[];
        $field='id,name,bar_code,price,cos_price,vip_price,image,images,stock,is_show';
        if($name){
            array_push($search,'name');
            $where['name']=$name;
        }
        if($is_show !=null){
            array_push($search,'is_show');
            $where['is_show']=$is_show;
        }
        /** @var GoodsService $result */
        $result=app()->make(GoodsService::class);
        $list=$result->list($search,$where,$field);
        return $this->success($list);
//        return json($list);
    }
    //产品详细信息
    public function info()
    {
        $id=$this->request->param('id');
        if(!$id) return $this->fail(2002);
        /** @var GoodsService $result */
        $result=app()->make(GoodsService::class);
        $list=$result->info($id);
        return json(['code'=>2000,'data'=>$list]);
    }
    public function upload(){
        $file = $this->request->file('file');
        if(!$file){
            return $this->fail(4003);
        }
        /** @var FileService $result */
        $result=app()->make(FileService::class);
        $path=$result->image($file,'goods');
        if(!$path) return $this->fail(4002);
        return json(['code'=>2000,'path'=>$path]);
    }
    public function create(ProductValidate $validate){
        $result=$validate->check($this->request->all());
        if(!$result){
            return $this->fail($validate->getError());
        }
        /** @var GoodsService $service */
        $service=app()->make(GoodsService::class);
        $res=$service->create($this->request->all());
        if($res) return $this->tips(2000);
        return $this->fail();
    }
    public function update(ProductValidate $validate){
        $result=$validate->sceneEdit()->check($this->request->all());
        if(!$result){
            return $this->fail($validate->getError());
        }
        /** @var GoodsService $service */
        $service=app()->make(GoodsService::class);
        $res=$service->update($this->request->all());
        if($res) return $this->tips(2000);
        return $this->fail();
    }
    public function isShow(){
        $id=$this->request->param('id');
        $is_show=$this->request->param('is_show');
        /** @var GoodsService $service */
        $service=app()->make(GoodsService::class);
        $res=$service->isShow($id,$is_show);
        if($res) return $this->tips(2000);
        return $this->fail();
    }
    public function del(){
        $path = $this->request->file('path');
        if(!$path){
            return $this->fail(4007);
        }
        /** @var FileService $result */
        $result=app()->make(FileService::class);
        $result->delete($path);
        return $this->tips(2000);
    }
}