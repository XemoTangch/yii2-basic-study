<?php
/**
 * Author: jiangm
 * Email: jmphper@foxmail.com
 * Date: 2018/4/25
 * Time: 15:27
 * Desc: 配置允许所有访问的节点
 */

return [
    'class' => 'mdm\admin\components\AccessControl',
    'allowActions' => [
        'site/*',
        'front/*',
        'demo/*',
        'backend/*',
        '*'
    ],
];