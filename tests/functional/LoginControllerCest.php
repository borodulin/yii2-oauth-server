<?php

namespace oauth\tests\functional;

use oauth\tests\functional\fixtures\Oauth2ClientFixture;
use oauth\tests\functional\fixtures\UserFixture;
use oauth\tests\FunctionalTester;

class LoginControllerCest
{
    public function _fixtures()
    {
        return [
            UserFixture::class,
            Oauth2ClientFixture::class,
        ];
    }

    public function testOpeningLoginPageWithoutAnyInformation(FunctionalTester $I)
    {
        $I->amOnRoute('oauth');
        $I->seeResponseCodeIs(400);
        $I->see('Invalid or missing response type.');
        $I->see('invalid_request');
    }

    public function testOpeningLoginPageWithInvalidResponseType(FunctionalTester $I)
    {
        $I->amOnRoute('oauth', ['response_type' => 'test']);
        $I->seeResponseCodeIs(400);
        $I->see('An unsupported response type was requested.');
        $I->see('unsupported_response_type');
    }

    public function testOpeningLoginPageWithMissingClientId(FunctionalTester $I)
    {
        $I->amOnRoute('oauth', ['response_type' => 'code']);
        $I->seeResponseCodeIs(400);
        $I->see('Client Id cannot be blank.');
        $I->see('invalid_request');
    }

    public function testOpeningLoginPageWithClientIdButWithoutResponseType(FunctionalTester $I)
    {
        $I->amOnRoute('oauth', ['client_id' => 'test']);
        $I->seeResponseCodeIs(400);
        $I->see('Invalid or missing response type.');
        $I->see('invalid_request');
    }

    public function testOpeningLoginPageWithUnknownClientId(FunctionalTester $I)
    {
        $I->amOnRoute('oauth', ['response_type' => 'code', 'client_id' => 'test']);
        $I->seeResponseCodeIs(400);
        $I->see('Unknown client.');
        $I->see('invalid_client');
    }

    public function testOpeningLoginPage(FunctionalTester $I)
    {
        $I->amOnRoute('oauth', ['response_type' => 'code', 'client_id' => 'existing']);
        $I->seeResponseCodeIs(200);
        $I->see('username');
        $I->see('password');
    }

    public function testLoggingInWithWrongUsername(FunctionalTester $I)
    {
        $I->amOnRoute('oauth', ['response_type' => 'code', 'client_id' => 'existing']);
        $I->fillField('LoginForm[username]', 'nonexistent');
        $I->fillField('LoginForm[password]', 'nonexistent');
        $I->click('Login');

        $I->see('Incorrect username or password.');
    }

    public function testLoggingInWithIncorrectPassword(FunctionalTester $I)
    {
        $I->amOnRoute('oauth', ['response_type' => 'code', 'client_id' => 'existing']);
        $I->fillField('LoginForm[username]', 'correct');
        $I->fillField('LoginForm[password]', 'nonexistent');
        $I->click('Login');

        $I->see('Incorrect username or password.');
    }

    public function testLoggingInWithCorrectPassword(FunctionalTester $I)
    {
        $I->followRedirects(false);
        $I->amOnRoute('oauth', ['response_type' => 'code', 'client_id' => 'existing', 'redirect_uri' => 'https://example.org/']);
        $I->fillField('LoginForm[username]', 'correct');
        $I->fillField('LoginForm[password]', 'correct');
        $I->click('Login');

        $I->seeResponseCodeIs(302);

        $I->seeHeaderContains('location', 'https://example.org/?code=');
    }
}
