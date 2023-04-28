<?php
declare (strict_types = 1);

namespace app\api\middleware;
use app\services\ApiTokenService as TokenServer;
class CheckToken
{
    protected $token;

    public function __construct(TokenServer $token)
    {
        $this->token = $token;
    }
    /**
     * 处理请求
     *
     * @param \think\Request $request
     * @param \Closure       $next
     * @return Response
     */
    public function handle($request, \Closure $next)
    {
        //第一步先取token
        $auth = $request->header('Authorization');
        if(!isset($auth)){
            return json(['code'=>4004,'msg'=>'request must with token']);
        }
        $token = trim(ltrim($request->header('Authorization'), 'Bearer'));
        //jwt进行校验token
        $res = $this->token->chekToken($token);
        if ($res['code'] != 1 ){
            return json(['code'=>4004,'msg'=>$res['msg'],'data'=>''],400);
        }
        $request->uid = $res['data']->uid;
        if(!isset($res['token'])){
            return $next($request);
        }
        return $next($request)->header(['ApiToken'=>$res['token']]);
    }
}
