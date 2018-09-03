<?php

use yii\helpers\ArrayHelper;
use yii\web\AssetManager;

return ArrayHelper::merge(require 'test.php', [
    'controllerNamespace' => 'yiiacceptance\controllers',
    'components' => [
        'request' => [
            'enableCookieValidation' => false,
        ],
        'assetManager' => [
            'class' => AssetManager::class,
            'basePath' => dirname(__DIR__) . '/web/assets',
        ],
        'user' => [
            'identityClass' => 'yiiacceptance\models\User',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
        ]
    ]
]);
