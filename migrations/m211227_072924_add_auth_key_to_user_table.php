<?php

use yii\db\Migration;

/**
 * Class m211227_072924_add_auth_key_to_user_table
 */
class m211227_072924_add_auth_key_to_user_table extends Migration
{

    public function safeUp()
    {
        $this->addColumn('user', 'auth_key', $this->string()->notNull());
    }


    public function safeDown()
    {
        echo "m211227_072924_add_auth_key_to_user_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211227_072924_add_auth_key_to_user_table cannot be reverted.\n";

        return false;
    }
    */
}
