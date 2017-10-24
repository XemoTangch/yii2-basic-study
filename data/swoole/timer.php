<?php
/**
 * Author: jiangm
 * Email: jmphper@foxmail.com
 * Date: 2017/10/24
 * Time: 15:02
 * Desc: 计时器
 */

//每隔2000ms触发一次
swoole_timer_tick(2000, function ($timer_id) {
    echo "tick-2000ms\n";
});

//3000ms后执行此函数
swoole_timer_after(3000, function () {
    echo "after 3000ms.\n";
});