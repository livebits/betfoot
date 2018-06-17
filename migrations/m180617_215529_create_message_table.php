<?php

use yii\db\Migration;

/**
 * Handles the creation of table `message`.
 */
class m180617_215529_create_message_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('message', [
            'id' => 'pk',
            'user_id' => 'int',
            'parent_id' => 'int',

            'subject' => $this->string(),
            'message' => $this->string(),

            'status' => $this->string(),

            'updated_at' => 'int',
            'created_at' => 'int',
        ], $tableOptions);


        $this->addForeignKey('fk_message_user_id', 'message', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_message_user_id', 'message');

        $this->dropTable('message');
    }
}
