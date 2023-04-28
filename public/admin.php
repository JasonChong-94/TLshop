<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2022/11/24
 * Time: 14:06
 */
// [ 应用入口文件 ]
namespace think;

require __DIR__ . '/../vendor/autoload.php';

// 执行HTTP应用并响应
$http = (new  App())->http;
$response = $http->run();
$response->send();
$http->end($response);