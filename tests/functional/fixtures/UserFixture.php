<?php

namespace oauth\tests\functional\fixtures;

use yii\test\ActiveFixture;
use yiiacceptance\models\User;

class UserFixture extends ActiveFixture
{
    public $modelClass = User::class;
}
