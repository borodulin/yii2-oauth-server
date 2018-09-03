<?php

namespace yiiacceptance\controllers;

use conquer\oauth2\granttypes\Authorization;
use conquer\oauth2\granttypes\RefreshToken;
use conquer\oauth2\granttypes\UserCredentials;
use conquer\oauth2\granttypes\ClientCredentials;

class ClientCredentialsController extends \yii\rest\Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'token' => [
                'class' => \conquer\oauth2\TokenAction::class,
                'grantTypes' => [
                    'refresh_token' => RefreshToken::class,
                    'client_credentials' => ClientCredentials::class,
                ],
            ],
        ];
    }
}
