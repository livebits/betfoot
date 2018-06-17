<?php

use yii\db\Migration;

/**
 * Handles the creation of table `withdraw`.
 */
class m180618_005529_create_withdraw_table extends Migration
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

        $this->createTable('withdraw', [
            'id' => 'pk',
            'user_id' => 'int',

            'price' => $this->integer(),
            'account_owner' => $this->string(),
            'bank_name' => $this->string(),
            'account_number' => $this->string(),
            'card_number' => $this->string(),
            'shaba_number' => $this->string(),

            'status' => $this->string(),

            'updated_at' => 'int',
            'created_at' => 'int',
        ], $tableOptions);


        $this->addForeignKey('fk_withdraw_user_id', 'withdraw', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_withdraw_user_id', 'withdraw');

        $this->dropTable('withdraw');
    }
}
