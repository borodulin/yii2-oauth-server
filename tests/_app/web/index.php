<?php
require(__DIR__ . '/../../../vendor/autoload.php');
require(__DIR__ . '/../../../vendor/yiisoft/yii2/Yii.php');

Yii::setAlias('yiiacceptance', dirname(__DIR__));

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

// load application configuration
$config = [
    'id' => 'test',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => 'test/index',
    'aliases' => [
        '@bower' => __DIR__ . '/../../../vendor/bower-asset',
    ],
    'bootstrap' => ['log'],
    'controllerNamespace' => 'yiiacceptance\controllers',
    'components' => [
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'request' => [
            'enableCookieValidation' => false
        ]
    ]
];

// instantiate and configure the application
(new yii\web\Application($config))->run();
