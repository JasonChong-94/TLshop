<?php
declare (strict_types = 1);

namespace app\admin\middleware;
use app\services\AdminTokenService as TokenServer;
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
        $request->withHeader(['newtoken'=>111]);
        if(!isset($auth)){
            return json(['code'=>440,'msg'=>'request must with token']);
        }
        $token = trim(ltrim($auth, 'Bearer'));
        //jwt进行校验token
        $res = $this->token->chekToken($token);
        if ($res['code'] != 1 ){
            return json(['code'=>999,'msg'=>$res['msg'],'data'=>''],400);
        }
        $request->aid = $res['data']->aid;
        return $next($request);
    }
}
