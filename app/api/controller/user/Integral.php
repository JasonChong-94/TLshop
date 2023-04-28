<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2023/4/15
 * Time: 15:04
 */

namespace app\api\controller\user;

use app\BaseController;
use app\services\MemberService;

class Integral extends BaseController
{

    //积分记录
    public function index()
    {
        $page=$this->request->param('page',1);
        $type=$this->request->param('type',1);
        $where[] = ['type','=',$type];
        $where[] = ['user_id','=',$this->request->uid];
        /** @var MemberService $member */
        $member=app()->make(MemberService::class);
        $data=$member->integralList($where,$page);
        return $this->success($data);

    }
    //提现记录
    public function extract(){
        $page=$this->request->param('page',1);
        $where[] = ['way','=',1];
        $where[] = ['user_id','=',$this->request->uid];
        /** @var MemberService $member */
        $member=app()->make(MemberService::class);
        $data=$member->extractList($where,$page);
        return $this->success($data);
    }
    public function inIntegral(){
        /** @var MemberService $member */
        $member=app()->make(MemberService::class);
        $data=$member->billWrite(1,[2,3],1);
        return json(['data'=>$data]);
    }
}
