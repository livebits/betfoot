<?php

use yii\db\Migration;

/**
 * Handles the creation of table `transaction`.
 */
class m180615_145729_create_transaction_table extends Migration
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

        $this->createTable('transaction', [
            'id' => 'pk',
            'user_id' => 'int',

            'amount' => $this->bigInteger(),
            'authority' => 'string',
            'status' => 'string',

            'created_at' => 'int',
        ], $tableOptions);


        $this->addForeignKey('fk_transaction_user_id', 'transaction', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_transaction_user_id', 'transaction');

        $this->dropTable('transaction');
    }
}
