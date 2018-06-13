<?php

use yii\db\Migration;

/**
 * Handles the creation of table `profile`.
 */
class m180612_125729_create_profile_table extends Migration
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

        $this->createTable('user_profile', [
            'id' => 'pk',
            'user_id' => 'int',

            'firstName' => 'string',
            'lastName' => 'string',
            'mobile' => 'string',

            'created_at' => 'int',
            'updated_at' => 'int',
        ], $tableOptions);


        $this->addForeignKey('fk_user_profile_user_id', 'user_profile', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_user_profile_user_id', 'user_profile');

        $this->dropTable('user_profile');
    }
}
