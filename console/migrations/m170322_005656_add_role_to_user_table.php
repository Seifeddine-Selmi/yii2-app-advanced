<?php

use yii\db\Migration;
use yii\db\Schema;

class m170322_005656_add_role_to_user_table extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'role', $this->integer()->defaultValue(10)->notNull());
    }

    public function down()
    {
        $this->dropColumn('user', 'role');
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
