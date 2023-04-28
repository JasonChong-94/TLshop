<?php
/**
 * Created by PhpStorm.
 * UserController: 联想
 * Date: 2022/11/22
 * Time: 15:00
 */
namespace app\api\controller\user;

use app\api\validate\User;
use app\BaseController;
use app\model\User as UserModel;
use app\services\MemberService;
use app\services\ApiTokenService as TokenServer;
use app\services\MiniProgramService;

class Index extends BaseController
{

    public function index()
    {
        $user=UserModel::withSearch(['nickname','create_time'], [
            'name'			=>	'1111',
            'create_time'	=>	['2022-8-1','2022-12-5'],
            'status'		=>	1
        ])
//            ->field('nickname')
            ->select();
        $data = ['data' => $user, 'status' => '10','uid'=>$this->request->uid];
        return json($data);

    }
    //账户密码登录
    public function login()
    {
        //获取code码
        $name = $this->request->param('name','111');
        $pwd = $this->request->param('pwd','111111');
        /*if(!$name || !$pwd){
            return $this->fail(2002);
        }*/
//        $id = User::where('name',$name)->value('id');
        $map[] = ['account','=',$name];
        $map[] = ['pwd','=',md5($pwd)];
        $user=UserModel::where($map)->find();
        if(!$user){
            return $this->fail(2006);
        }
        //生成token,保存用户登录状态
        $token = (new TokenServer())->generateToken($user->id);
        return $this->success(['token'=>$token],2005);
    }
    //微信授权登陆 openid
    public function wxLogin()
    {
        //获取code码
        $code = $this->request->param('code');
        if(!$code){
            return $this->fail(2002);
        }
        /** @var MiniProgramService $wechat */
        $wechat=app()->make(MiniProgramService::class);
        $userinfo=$wechat->getUserInfo($code);
        $id = UserModel::where('openid',$userinfo['openid'])->value('id');
        if(!$id){
            return $this->fail(2003);
        }
        //生成token,保存用户登录状态
        $token = (new TokenServer())->generateToken($id);
        return $this->success(['token'=>$token],2005);
    }
    public function register(User $request,MemberService $memberService)
    {
        $code = $this->request->param('code');
        $invite_code = $this->request->param('invite_code');
        $result=$request->check($this->request->all());
        if(!$result){
            return $this->fail($request->getError());
        }
        /** @var MiniProgramService $wechat */
        $wechat=app()->make(MiniProgramService::class);
        $userinfo=$wechat->getUserInfo($code);
        $res=$memberService->register($userinfo['openid'],$invite_code,$this->request->only(['phone','pwd']));
        if(!$res){
            return $this->fail(2008);
        }
        return $this->tips(2009);
    }
    public function info(){
        $info=UserModel::find($this->request->uid)->toArray();
//        $member=app()->make(MemberService::class);
//        $member->monthBill(1);
        return $this->success($info);
    }
}
