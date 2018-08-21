<?php

use yii\console\controllers\MigrateController;
use yii\helpers\ArrayHelper;

return ArrayHelper::merge(require 'test.php', [
    'controllerNamespace' => 'app\commands',
    'components' => [

    ],
    'controllerMap' => [
        'migrate' => [
            'class' => MigrateController::class,
            'migrationPath' => [
                '@app/migrations',
                '@conquer/oauth2/migrations'
            ],
        ],
    ],
]);
