<?php
/**
 * Author: jiangm
 * Email: jmphper@foxmail.com
 * Date: 2017/10/24
 * Time: 17:08
 * Desc: http 客户端 支持大量并发
 */

$cli = new swoole_http_client('127.0.0.1', 80);
$cli->setHeaders(['User-Agent' => "swoole"]);

$cli->post('http://127.0.0.1/git/yii2-basic-study/data/swoole/dump.php', array("test" => 'abc'), function ($cli) {
    echo $cli->body;
});