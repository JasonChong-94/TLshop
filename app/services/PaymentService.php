<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2023/1/17
 * Time: 17:00
 */


namespace app\services;
use EasyWeChat\Pay\Application;
use EasyWeChat\Pay\Message;

class PaymentService
{
    const APPID='';
    protected $pay;
    public function _initialize(){
        $config = [
            'mch_id' => '',

            // 商户证书
            'private_key' => '',
            'certificate' => '',

            // v3 API 秘钥
            'secret_key' => '',

            // v2 API 秘钥
            'v2_secret_key' => '',

            // 平台证书：微信支付 APIv3 平台证书，需要使用工具下载
            // 下载工具：https://github.com/wechatpay-apiv3/CertificateDownloader
            'platform_certs' => [
                // '/path/to/wechatpay/cert.pem',
            ],

            /**
             * 接口请求相关配置，超时时间等，具体可用参数请参考：
             * https://github.com/symfony/symfony/blob/5.3/src/Symfony/Contracts/HttpClient/HttpClientInterface.php
             */
            'http' => [
                'throw'  => true, // 状态码非 200、300 时是否抛出异常，默认为开启
                'timeout' => 5.0,
                // 'base_uri' => 'https://api.mch.weixin.qq.com/', // 如果你在国外想要覆盖默认的 url 的时候才使用，根据不同的模块配置不同的 uri
            ],
        ];

        $this->pay = new Application($config);
    }
    /**
     * 初始化支付接口
     * @return object
     */
    public static function application()
    {
        if(self::$instance==null){
            self::$instance = new Application(self::options());
        };
        return self::$instance;
    }
    /**
     * 小程序调起支付 配置
     * @param string $prepayId
     * @return object
     */
    public function buildMiniAppConfig($prepayId)
    {
        $signType = 'RSA'; // 默认RSA，v2要传MD5
        return $this->pay->getUtils()->buildMiniAppConfig($prepayId, self::APPID, $signType);
    }
    /**
     * jsApi下单获得下单ID prepay_id
     * @param $openid
     * @param $out_trade_no
     * @param $total_fee
     * @param $body
     * @return mixed
     */
    public function paymentOrder($openid, $out_trade_no, $total_fee, $body){
        $response = $this->pay->getClient()->postJson("v3/pay/transactions/jsapi", [
            "mchid" => '',
            "out_trade_no" => $out_trade_no,
            "appid" => self::APPID,
            "description" => $body,
            "notify_url" => "https://weixin.qq.com/",
            "amount" => [
                "total" => $total_fee,
                "currency" => "CNY"
            ],
            "payer" => [
                "openid" => $openid
            ]
        ]);

        var_dump($response->prepay_id);

    }
    public function callback(){

        $server = $this->pay->getServer();
        $server->handlePaid(function (Message $message, \Closure $next) {
            // $message->out_trade_no 获取商户订单号
            // $message->payer['openid'] 获取支付者 openid
            // 🚨🚨🚨 注意：推送信息不一定靠谱哈，请务必验证
            // 建议是拿订单号调用微信支付查询接口，以查询到的订单状态为准
            return $next($message);
        });

// 默认返回 ['code' => 'SUCCESS', 'message' => '成功']
        return $server->serve();



    }





}