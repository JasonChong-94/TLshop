<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2022/12/13
 * Time: 17:00
 */

namespace app\api\controller\user;

use app\BaseController;
use app\api\validate\UserAddress;
use app\model\UserAddress as AddressModel;

class Address extends BaseController
{

    public function index()
    {
        $user=AddressModel::where('user_id',$this->request->uid)->select();
        return $this->success($user);

    }
    public function add()
    {
        $data=$this->request->all();
        $validate = new UserAddress();
        $result = $validate->check($data);

        if(!$result){
            $res = ['data' => $validate->getError(), 'code' => 2002];
            return json($res);
        }
        if($data['default']==1){
            AddressModel::editDefault($this->request->uid);
        }
        $user = new AddressModel;
        $user->user_id=$this->request->uid;
        $user->save($data);
        return $this->success($data);
    }
}
