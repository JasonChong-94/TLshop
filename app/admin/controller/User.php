<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2023/2/6
 * Time: 16:17
 */

namespace app\admin\controller;

use app\BaseController;
use app\model\User as UserModel;
class User extends BaseController
{

    //用户列表
    public function index()
    {
        $nickname=$this->request->param('nickname');
        $search=[];
        $where=[];
//        $field='id,order_no,parent_no,transaction_id,user_id';
        if($nickname){
            array_push($search,'nickname');
            $where['nickname']=$nickname;
        }
        $data=UserModel::withSearch($search,$where)
//            ->field($field)
            ->paginate(10);
        return $this->success($data);

    }
}
