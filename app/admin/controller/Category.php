<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2023/2/17
 * Time: 11:38
 */
namespace app\admin\controller;

use app\admin\validate\CategoryValidate;
use app\BaseController;
use app\services\CategoryService;
class Category extends BaseController
{

    //列表显示
    public function index(CategoryService $service)
    {
        $search=[];
        $where=[];
        $cate_name=$this->request->param('cate_name');
        if($cate_name){
            $search=['cate_name'];
            $where=[
                'cate_name'	    =>	$cate_name,
            ];
        }
        $list=$service->gList($search,$where);
        return $this->success($list);
    }
    //一级菜单
    public function pcate(CategoryService $service){
        $search=['pid'];
        $where=[
            'pid'	    =>	0,
        ];
        $list=$service->gList($search,$where);
        return $this->success($list);
    }
    public function create(CategoryValidate $request,CategoryService $service){
        $result=$request->check($this->request->all());
        if(!$result){
            return $this->fail($request->getError());
        }
        $res=$service->create($this->request->all());
        if($res) return $this->tips(2000);
    }
    public function update(CategoryValidate $request,CategoryService $service){
        $result=$request->sceneEdit()->check($this->request->all());
        if(!$result){
            return $this->fail($request->getError());
        }
        $res=$service->update($this->request->all());
        if($res) return $this->tips(2000);
    }
}