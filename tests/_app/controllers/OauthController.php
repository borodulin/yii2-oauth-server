<?php

namespace yiiacceptance\controllers;

use conquer\oauth2\granttypes\Authorization;
use conquer\oauth2\granttypes\RefreshToken;
use conquer\oauth2\granttypes\UserCredentials;
use Yii;
use yii\web\Controller;
use yiiacceptance\models\forms\LoginForm;

class OauthController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'oauth2Auth' => [
                'class' => \conquer\oauth2\AuthorizeFilter::class,
                'only' => ['index'],
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'token' => [
                'class' => \conquer\oauth2\TokenAction::class,
                'grantTypes' => [
                    'authorization_code' => Authorization::class,
                    'refresh_token' => RefreshToken::class,
                    'password' => UserCredentials::class,
                ],
            ],
        ];
    }

    /**
     * Display login form, signup or something else.
     * AuthClients such as Google also may be used
     */
    public function actionIndex()
    {
        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $this->finishAuthorization();
        }

        $model->password = '';

        return $this->render('index', [
            'model' => $model,
        ]);
    }

}
