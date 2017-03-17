<?php

use yii\db\Migration;
use yii\db\Schema;

class m170316_170153_add_first_name_and_last_name_to_user_table extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'first_name', Schema::TYPE_STRING . '(256) NOT NULL');
        $this->addColumn('user', 'last_name', Schema::TYPE_STRING . '(256) NOT NULL');
    }

    public function down()
    {
        $this->dropColumn('user', 'first_name');
        $this->dropColumn('user', 'last_name');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
