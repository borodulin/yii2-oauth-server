<?php
/**
 * @link https://github.com/borodulin/yii2-oauth2-server
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-oauth2-server/blob/master/LICENSE
 */

namespace conquer\oauth2\granttypes;

class Implicit extends GrantTypeAbstract
{
    public $client_id;
    public $response_type;
    public $state;
    public $redirect_uri;
    public $scope;

    public function rules()
    {
        return [
            [['client_id'], 'required'],
            [['client_id'], 'string', 'max' => 80],
            [['redirect_uri'], 'url'],
            [['client_id'], 'validateClient_id'],
            [['scope'], 'validateScope'],
        ];
    }
    
    public function getResponseData()
    {
        $acessToken = \conquer\oauth2\models\AccessToken::createAccessToken([
            'client_id' => $this->client_id,
            'user_id' => \Yii::$app->user->id,
            'expires' => $this->accessTokenLifetime + time(),
            'scope' => $this->scope,
        ]);
    
        $refreshToken = \conquer\oauth2\models\RefreshToken::createRefreshToken([
            'client_id' => $this->client_id,
            'user_id' => \Yii::$app->user->id,
            'expires' => $this->refreshTokenLifetime + time(),
            'scope' => $this->scope,
        ]);

        return  [
            'access_token' => $acessToken->access_token,
            'expires_in' => $this->accessTokenLifetime,
            'token_type' => $this->tokenType,
            'scope' => $this->scope,
            'refresh_token' => $refreshToken->refresh_token,
        ];
    }
}