<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2022/12/2
 * Time: 17:17
 */

namespace app\api\controller\product;

use app\BaseController;
use app\model\ProductReply;

class Reply extends BaseController
{

    public function index()
    {
        $id=$this->request->param('id');
        if(!$id){
            return $this->fail(2002);
        }
        $data=ProductReply::withSearch(['status','product_id'], [
            'status'			=>	1,
            'product_id'		=>	$id,
        ])
            ->field('score,comment,images,nickname,avatar')
            ->select();
        return $this->success($data);
    }
    public function create(){
        $data=$this->request->all();

        $user = new ProductReply;
        $user->user_id=$this->request->uid;
        $user->add_time=date('Y-m-d H:i:s');
        $user->save($data);
        return $this->tips(2000);
    }
}
