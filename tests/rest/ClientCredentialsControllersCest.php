<?php

namespace oauth\tests\rest;

use oauth\tests\rest\fixtures\Oauth2ClientFixture;
use oauth\tests\RestTester;
use conquer\oauth2\models\AccessToken;
use conquer\oauth2\models\RefreshToken;


class ClientCredentialsControllersCest
{
    public function _fixtures()
    {
        return [
            Oauth2ClientFixture::class,
        ];
    }

    public function testLoggingInWithoutAnyInformation(RestTester $I)
    {
        $I->sendPost('client-credentials/token');

        $I->seeResponseCodeIs(400);
        $I->see('The grant type was not specified in the request.');
    }

    public function testLoggingInWithOnlyGrantType(RestTester $I)
    {
        $I->sendPost('client-credentials/token', [
            'grant_type' => 'client_credentials'
        ]);

        $I->seeResponseCodeIs(400);

        $I->see('Client Id cannot be blank.');
        $I->see('invalid_request');
    }

    public function testLoggingInGrantTypeAndWrongClientAndNoClientSecretId(RestTester $I)
    {
        $I->sendPost('client-credentials/token', [
            'grant_type' => 'client_credentials',
            'client_id' => 'test'
        ]);
        
        $I->seeResponseCodeIs(400);
        $I->see('Client Secret cannot be blank.');
        $I->see('invalid_request');
    }

    public function testLoggingInGrantTypeAndCorrectClientId(RestTester $I)
    {
        $I->sendPost('client-credentials/token', [
            'grant_type' => 'client_credentials',
            'client_id' => 'existing'
        ]);

        $I->seeResponseCodeIs(400);
        $I->see('Client Secret cannot be blank.');
        $I->see('invalid_request');
    }

    public function testLoggingInGrantTypeAndWrongClientAndClientSecret(RestTester $I)
    {
        $I->sendPost('client-credentials/token', [
            'grant_type' => 'client_credentials',
            'client_id' => 'test',
            'client_secret' => 'test'
        ]);

        $I->seeResponseCodeIs(400);
        $I->see('Unknown client.');
        $I->see('invalid_client');
    }

    public function testLoggingInWithGrantTypeClientAndWrongClientSecret(RestTester $I)
    {
        $I->sendPost('client-credentials/token', [
            'grant_type' => 'client_credentials',
            'client_id' => 'existing',
            'client_secret' => 'test'
        ]);

        $I->seeResponseCodeIs(400);
        $I->see('The client credentials are invalid');
        $I->see('unauthorized_client');
    }

    public function testLoggingInWithGrantTypeWrongClientAndClientSecret(RestTester $I)
    {
        $I->sendPost('client-credentials/token', [
            'grant_type' => 'client_credentials',
            'client_id' => 'test',
            'client_secret' => 'existing'
        ]);

        $I->seeResponseCodeIs(400);
        $I->see('Unknown client.');
        $I->see('invalid_client');
    }

    public function testLoggingIn(RestTester $I)
    {
        $I->sendPost('client-credentials/token', [
            'grant_type' => 'client_credentials',
            'client_id' => 'existing',
            'client_secret' => 'secret'
        ]);

        $I->seeResponseCodeIs(200);
    
        $I->seeResponseIsJson();

        $I->seeResponseContains("access_token");
        $I->seeResponseContains("expires_in");
    }

    public function testLoggingInAndGettingData(RestTester $I)
    {
        $I->sendPost('client-credentials/token', [
            'grant_type' => 'client_credentials',
            'client_id' => 'existing',
            'client_secret' => 'secret'
        ]);

        $I->seeResponseCodeIs(200);

        $I->seeResponseIsJson();

        $I->seeResponseContains("access_token");
        $I->seeResponseContains("expires_in");

        $accessToken = $I->grabDataFromResponseByJsonPath('$.access_token')[0];
        $refreshToken = $I->grabDataFromResponseByJsonPath('$.refresh_token')[0];

        $I->seeRecord(AccessToken::class, [
            'access_token' => $accessToken,
        ]);

        $I->seeRecord(RefreshToken::class, [
            'refresh_token' => $refreshToken,
        ]);
    }
}
