<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2022/11/23
 * Time: 14:46
 */
namespace app\services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class ApiTokenService
{
    const KEY='jason';

    /**
     * 生成token
     * @param $uid
     * @return mixed
     */
    function generateToken($uid)
    {
        //获取当前时间戳
        $currentTime = time();
        $data = array(
            "iss" => self::KEY,        //签发者 可以为空
            "aud" => '',             //面象的用户，可以为空
            "iat" => $currentTime,   //签发时间
            "nbf" => $currentTime,   //立马生效
            "exp" => $currentTime + 86400*15, //token 过期时间15day 两小时
            "data" => [              //记录的userid的信息，这里是自已添加上去的，如果有其它信息，可以再添加数组的键值对
                'uid' => $uid,
            ]
        );
        //生成token
        $token = JWT::encode($data, self::KEY, "HS256");  //根据参数生成了 token
        return $token;
    }
    /**
     * 校验token时效性
     */
    public function chekToken($token)
    {
        //eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJqYXNvbiIsImF1ZCI6IiIsImlhdCI6MTY2OTE5NTYyMywibmJmIjoxNjY5MTk1NjIzLCJleHAiOjE2NjkyMDI4MjMsImRhdGEiOnsidWlkIjoxfX0.2iplFMD_K07SbBnDrJXtdeA8XS0iruR8wXaXgBSi6e0
        $status=array("code"=>2);
        try {
            JWT::$leeway = 86400;//当前时间减去60，把时间留点余地
            $decoded = JWT::decode($token, new Key(self::KEY, 'HS256')); //HS256方式，这里要和签发的时候对应
            $arr = (array)$decoded;
            $res['code']=1;
            $res['data']=$arr['data'];
            if($arr['exp']<time()){
                //不足60s获取新token
                $token=$this->generateToken($arr['data']->uid);
                $res['token']=$token;
            }
            return $res;
        } catch(\Firebase\JWT\SignatureInvalidException $e) { //签名不正确
            $status['msg']="签名不正确";
            return $status;
        }catch(\Firebase\JWT\BeforeValidException $e) { // 签名在某个时间点之后才能用
            $status['msg']="token失效";
            return $status;
        }catch(\Firebase\JWT\ExpiredException $e) { // token过期
            $status['msg']="token过期";
            return $status;
        }catch(\Exception $e) { //其他错误
            $status['msg']="未知错误";
            return $status;
        }
    }
}