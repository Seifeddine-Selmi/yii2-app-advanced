<?php

use yii\db\Migration;

/**
 * Handles the creation of table `email`.
 */
class m170322_170023_create_email_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('email', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)->notNull(),
            'email' => $this->string(200)->notNull(),
            'subject' => $this->string(50)->notNull(),
            'content' => $this->text(),
            'attachment' => $this->string(255),
        ], $tableOptions);

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('email');
    }
}
