<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'zh-CN',
    'name' => 'LOVE STUDY LOVE WORK',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'defaultRoute' => 'site/index',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'myYii2',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        // url管理
        'urlManager' => [
            'enablePrettyUrl' => true, // 选择true，要在配置好域名后才能正常使用
            'showScriptName' => false, // 选择false，要在服务配置中重写路由
            'rules' => [
            ],
        ],
        'myComponent' => [
            'class' => 'app\components\MyComponent'
        ],
        // 自定义资源包
        'assetManager' => [
//            'linkAssets' => true, // 资源管理器会创建一个符号链接到要发布的资源包源路径， 这比拷贝文件方式快并能确保发布的资源一直为最新的
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'sourcePath' => null,   // 一定不要发布该资源
                    'js' => [
                        '//apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js',
                    ]
                ],
            ],
        ],
    ],
    'params' => $params,
    'modules' => [
        // 将模块配置到主体配置中才可以访问模块
        'front' => [
            'class' => 'app\modules\front\frontModule',
            // ... 模块其他配置 ...
        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    // 配置文件中 YII_ENV 为 dev ，YII_DEBUG 为 true 时
    if(YII_DEBUG){
        $config['bootstrap'][] = 'debug';
        $config['modules']['debug'] = [
            'class' => 'yii\debug\Module',
            // uncomment the following to add your IP if you are not connecting from localhost.
            'allowedIPs' => ['127.0.0.1', '::1', '192.168.33.1'],
        ];
    }

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.33.1'],
    ];
}

return $config;
