<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2023/2/8
 * Time: 16:23
 */
namespace app\admin\controller;

use app\admin\validate\AdminUserValidate;
use app\services\AdminRoleService;
use app\BaseController;
class Index extends BaseController
{

    public function login()
    {
        $account = $this->request->param('account');
        $pwd = $this->request->param('password');
        /** @var AdminRoleService $result */
        $result=app()->make(AdminRoleService::class);
        $info=$result->login($account,$pwd);
        if(!$info){
            return $this->fail(2006);
        }
        return $this->success($info,2005);
    }
    //账户更改
    public function save()
    {
        $id=$this->request->param('id');
        $validate=new AdminUserValidate();
        $result=$validate->check($this->request->all());
        if(!$result){
            return $this->fail($validate->getError());
        }
        /** @var AdminRoleService $result */
        $result=app()->make(AdminRoleService::class);
        $info=$result->save($id,$this->request->all());
        return $this->tips(2013);
    }
    public function list()
    {
        $field='id,account,name';
        /** @var AdminRoleService $result */
        $result=app()->make(AdminRoleService::class);
        $info=$result->list($field);
        return $this->success($info,2000);
    }
}
