<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2022/12/12
 * Time: 17:35
 */
namespace app\services;

class WechatService
{

    protected $config = [
        'app_id' => '',//appid
        'sp_appid' => '',//服务商appid
        'sp_mchid' => '',//服务商户号
        'sub_mchid' => '',//子商户号
        'key' => '',//密钥
        'serial_no' => '',//证书序列号
        'api_cert' => ROOT_PATH . 'cert/apiclient_cert.pem',//证书
        'api_key' => ROOT_PATH . 'cert/apiclient_key.pem'   //私钥

    ];


    public function sppay($data)
    {
        $payData = [
            'sp_appid' => $this->config['sp_appid'],//服务商应用ID
            'sp_mchid' => $this->config['sp_mchid'],//服务商户号
            'sub_mchid' => $this->config['sub_mchid'],//子商户号
            'sub_appid' => $this->config['app_id'],
            'description' => $data['body'],//商品描述
            'out_trade_no' => $data['out_trade_no'],//商户订单号
            'notify_url' => $data['notify_url'],//通知地址
            'amount' => [
                'total' => intval($data['total_fee']),
                'currency' => "CNY"
            ],
            'payer' => [
                "sub_openid" => ''//
            ]
        ];
        $url = "https://api.mch.weixin.qq.com/v3/pay/partner/transactions/jsapi";
        $headers = $this->sign('POST', $url, json_encode($payData));
        $data = $this->curl_post($url, json_encode($payData), $headers);
        $prepay_id = json_decode($data, true);
        $appId = $this->config['app_id'];
        $timeStamp = strval(time());
        $nonceStr = getRandChar(30);
        $package = "prepay_id=" . $prepay_id['prepay_id'];
        $signType = 'RSA';
        $resultData = [
            'appId' => $appId,
            'timeStamp' => $timeStamp,
            'nonceStr' => $nonceStr,
            'package' => $package,
            'signType' => $signType,
            'paySign' => $this->paySign($appId, $timeStamp, $nonceStr, $package),
        ];
        return $resultData;
    }

    public function paySign($appId, $timeStamp, $nonceStr, $package)
    {
        $mch_private_key = openssl_get_privatekey(file_get_contents($this->config['api_key']));
        $message = $appId . "\n" . //appid
            $timeStamp . "\n" .//时间戳
            $nonceStr . "\n" .
            $package . "\n";
        //计算签名值
        openssl_sign($message, $raw_sign, $mch_private_key, 'sha256WithRSAEncryption');
        $sign = base64_encode($raw_sign);
        // print_r($sign);exit;
        return $sign;
    }

    /**
     * @S: ----{--------------------------->
     * @Name: 方法: 请求报文主题
     * @Author: Fcy
     * @return {*}
     * @Date: 2022-10-25 14:12:46
     * @D: ----{--------------------------->
     * @param {*} $http_method
     * @param {*} $url
     * @param {*} $body
     */
    public function sign($http_method = 'POST', $url = '', $body = '')
    {
        $mch_private_key = openssl_get_privatekey(file_get_contents($this->config['api_key']));
        $timestamp = time();//时间戳
        $nonce = getRandChar(32);//随机串
        $url_parts = parse_url($url);
        $canonical_url = ($url_parts['path'] . (!empty($url_parts['query']) ? "?${url_parts['query']}" : ""));
        //构造签名串
        $message = $http_method . "\n" .
            $canonical_url . "\n" .
            $timestamp . "\n" .
            $nonce . "\n" .
            $body . "\n";//报文主体
        //计算签名值
        openssl_sign($message, $raw_sign, $mch_private_key, 'sha256WithRSAEncryption');
        $sign = base64_encode($raw_sign);
        //设置HTTP头
        $config = $this->config;
        $token = sprintf('WECHATPAY2-SHA256-RSA2048 mchid="%s",nonce_str="%s",timestamp="%d",serial_no="%s",signature="%s"',
            $config['sp_mchid'], $nonce, $timestamp, $config['serial_no'], $sign);
        $headers = [
            'Accept: application/json',
            'User-Agent: */*',
            'Content-Type: application/json; charset=utf-8',
            'Authorization: ' . $token,
        ];
        return $headers;
    }


    /**
     * @S: ----{--------------------------->
     * @Name: 方法: post
     * @Author: Fcy
     * @return {*}
     * @Date: 2022-10-25 14:10:45
     * @D: ----{--------------------------->
     * @param {*} $url
     * @param {*} $data
     * @param {*} $headers
     */
    public function curl_post($url, $data, $headers = array())
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        //设置header头
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        // POST数据
        curl_setopt($ch, CURLOPT_POST, 1);
        // 把post的变量加上
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    /**
     * @S: ----{--------------------------->
     * @Name: 方法: get
     * @Author: Fcy
     * @return {*}
     * @Date: 2022-10-25 14:11:18
     * @D: ----{--------------------------->
     * @param {*} $url
     * @param {*} $headers
     */
    public function curl_get($url, $headers = array())
    {
        $info = curl_init();
        curl_setopt($info, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($info, CURLOPT_HEADER, 0);
        curl_setopt($info, CURLOPT_NOBODY, 0);
        curl_setopt($info, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($info, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($info, CURLOPT_SSL_VERIFYHOST, false);
        //设置header头
        curl_setopt($info, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($info, CURLOPT_URL, $url);
        $output = curl_exec($info);
        curl_close($info);
        return $output;
    }
}