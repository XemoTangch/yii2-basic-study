<?php
/**
 * Author: jiangm
 * Email: jmphper@foxmail.com
 * Date: 2018/4/25
 * Time: 15:27
 * Desc: 配置允许所有访问的节点
 */

$as_access = [
    'class' => 'mdm\admin\components\AccessControl',
    'allowActions' => [
        'site/*',
        'front/*',
        'demo/*',
        'authentication/*',
        'backend/*',
        'admin/*',
    ],
];

if (YII_ENV_DEV) {
    // 开发环境可访问
    $as_access['allowActions'][] = 'gii/*';
}

return $as_access;