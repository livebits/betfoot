<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_wallet`.
 */
class m180614_010300_create_user_wallet_table extends Migration
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

        $this->createTable('user_wallet', [
            'id' => 'pk',
            'user_id' => 'int',

            'amount' => 'int',
            'type' => 'string',
            'comment' => 'string',
            'ip' => 'string',

            'created_at' => 'int',
        ], $tableOptions);


        $this->addForeignKey('fk_user_wallet_user_id', 'user_wallet', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_user_wallet_user_id', 'user_wallet');

        $this->dropTable('user_wallet');
    }
}
