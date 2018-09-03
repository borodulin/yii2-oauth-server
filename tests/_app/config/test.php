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
            'dsn' => 'mysql:host=localhost;dbname=test_oauth',
            'username' => 'testuser',
            'password' => '12345678',
            'charset' => 'utf8',
        ],
    ]
];
