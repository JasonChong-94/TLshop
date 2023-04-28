<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2022/11/24
 * Time: 15:43
 */
namespace app\services;

use think\facade\Db;
use think\worker\Server;
define('HEARTBEAT_TIME', 20);
class Worker extends Server
{
    protected $socket = 'http://0.0.0.0:2345';

    public function onMessage($connection,$data)
    {
//        $res=Db::table('user')->where('id',$data)->find();
        $connection->send(json_encode($data));
    }
}