<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2023/2/18
 * Time: 11:32
 */
namespace app\services;
use EasyWeChat\MiniApp\Application;
class MiniProgramService
{
    protected static $instance;
    public static function options(){
        $config = [
            'app_id' => '',
            'secret' => '',
            'token' => '',
            'aes_key' => '',
            'http' => [
                'throw'  => true, // 状态码非 200、300 时是否抛出异常，默认为开启
                'timeout' => 5.0,
                // 'base_uri' => 'https://api.weixin.qq.com/', // 如果你在国外想要覆盖默认的 url 的时候才使用，根据不同的模块配置不同的 uri

                'retry' => true, // 使用默认重试配置
                //  'retry' => [
                //      // 仅以下状态码重试
                //      'http_codes' => [429, 500]
                //       // 最大重试次数
                //      'max_retries' => 3,
                //      // 请求间隔 (毫秒)
                //      'delay' => 1000,
                //      // 如果设置，每次重试的等待时间都会增加这个系数
                //      // (例如. 首次:1000ms; 第二次: 3 * 1000ms; etc.)
                //      'multiplier' => 3
                //  ],
            ],
        ];
        return $config;
    }
    /**
     * 初始化小程序接口
     * @return object
     */
    public static function miniApp()
    {
        if(self::$instance==null){
            self::$instance = new Application(self::options());
        };
        return self::$instance;
    }
    /**
     * 小程序工具类
     * @return object
     */
    /*public function getUtils(){
        return self::miniApp()->getUtils();
    }*/
    /**
     * 小程序获得用户信息 根据code 获取session_key
     * @param string $code
     * @return array
     */
    public function getUserInfo($code)
    {
//        $utils=$this->getUtils();
//        $response = $utils->codeToSession($code);
        $res=self::miniApp()->getUtils()->codeToSession($code);
        return json_decode($res,true);

// {
//     "openid": "o6_bmjrPTlm6_2sgVt7hMZOPxxxx",
//     "session_key": "tiihtNczf5v6AKRyjwExxxx=",
//     "unionid": "o6_bmasdasdsad6_2sgVt7hMZOxxxx",
//     "errcode": 0,
//     "errmsg": "ok"
//}
    }
    /**
     * 加密数据解密
     * @param $sessionKey
     * @param $iv
     * @param $encryptData
     * @return array
     */
    public function encryptor($sessionKey, $iv, $encryptData){
        $res=self::miniApp()->getUtils()->decryptSession($sessionKey, $iv, $encryptData);
        return json_decode($res,true);
//{
//    "openId": "oGZUI0egBJY1zhBYw2KhdUfwVJJE",
//    "nickName": "Band",
//    "gender": 1,
//    "language": "zh_CN",
//    "city": "Guangzhou",
//    "province": "Guangdong",
//    "country": "CN",
//    "avatarUrl": "http://wx.qlogo.cn/mmopen/vi_32/aSKcBBPpibyKNicHNTMM0qJVh8Kjgiak2AHWr8MHM4WgMEm7GFhsf8OYrySdbvAMvTsw3mo8ibKicsnfN5pRjl1p8HQ/0",
//    "unionId": "ocMvos6NjeKLIBqg5Mr9QjxrP1FA",
//    "watermark": {
//        "timestamp": 1477314187,
//        "appid": "wx4f4bc4dec97d474b"
//    }
//}
    }

}