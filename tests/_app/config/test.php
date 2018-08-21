<?php

return [
    'id' => 'test',
    'basePath' => dirname(__DIR__),
    'aliases' => [
        '@bower' => __DIR__ . '/../../../vendor/bower-asset',
        '@conquer/oauth2' => dirname(dirname(dirname(__DIR__))) . '/src',
    ],
    'bootstrap' => ['log'],
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
        'db' => [
            'class' => '\yii\db\Connection',
            'dsn' => 'mysql:host=mysql;dbname=test_oauth',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
    ]
];
