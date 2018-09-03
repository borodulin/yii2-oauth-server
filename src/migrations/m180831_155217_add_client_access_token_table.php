<?php
/**
 * @link https://github.com/borodulin/yii2-oauth2-server
 * @copyright Copyright (c) 2015 Andrey Borodulin
 * @license https://github.com/borodulin/yii2-oauth2-server/blob/master/LICENSE
 */

use yii\db\Schema;
use yii\db\Migration;

/**
 *
 * @author Andrey Borodulin
 *
 */
class m180831_155217_add_client_access_token_table extends Migration
{
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable('{{%oauth2_client_access_token}}', [
            'access_token' => $this->string(40)->notNull(),
            'client_id' => $this->string(80)->notNull(),
            'expires' => $this->integer()->notNull(),
            'scope' => $this->text(),
            'PRIMARY KEY (access_token)',
        ]);

        $this->addforeignkey('fk_oauth2_client_access_token_oauth2_client_client_id', '{{%oauth2_client_access_token}}', 'client_id', '{{%oauth2_client}}', 'client_id', 'cascade', 'cascade');

        $this->createIndex('ix_oauth2_client_access_token_refresh_token_expires', '{{%oauth2_client_access_token}}', 'expires');
    }

    public function safeDown()
    {
        $this->dropTable('{{%oauth2_client_access_token}}');
    }
}
