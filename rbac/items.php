<?php
return [
    'admin' => [
        'type' => 1,
        'description' => '后台管理',
        'children' => [
            '/demo/user-manage/index',
            '/demo/user-manage/create',
            '/demo/user-manage/update',
            '/demo/user-manage/detail',
        ],
    ],
    '/demo/user-manage/index' => [
        'type' => 2,
    ],
    '/demo/user-manage/create' => [
        'type' => 2,
    ],
    '/demo/user-manage/update' => [
        'type' => 2,
    ],
    '/demo/user-manage/detail' => [
        'type' => 2,
    ],
    '新增' => [
        'type' => 2,
        'children' => [
            '/demo/user-manage/create',
        ],
    ],
];
