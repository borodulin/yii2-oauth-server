<?php

namespace oauth\tests\functional\fixtures;

use yii\test\ActiveFixture;
use yiiacceptance\models\User;

class Oauth2ClientFixture extends ActiveFixture
{
    public $tableName ='oauth2_client';
}
