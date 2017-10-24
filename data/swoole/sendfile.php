<?php
/**
 * Author: jiangm
 * Email: jmphper@foxmail.com
 * Date: 2017/10/24
 * Time: 17:48
 * Desc: 客户端文件上传
 */

$client = new swoole_client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_SYNC); //同步阻塞
if (!$client->connect('127.0.0.1', 9501, -1))
{
    exit("connect failed. Error: {$client->errCode}\n");
}
if ($client->sendfile(__DIR__.'/dump.php') === false)
{
    exit("send failed. Error: {$client->errCode}\n");
//    break;
}
$data = $client->recv(7000);
if ($data === false)
{
    exit("recv failed. Error: {$client->errCode}\n");
//    break;
}
var_dump($data);
$client->close();