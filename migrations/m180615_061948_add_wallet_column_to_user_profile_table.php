<?php

use yii\db\Migration;

/**
 * Handles adding wallet to table `user_profile`.
 */
class m180615_061948_add_wallet_column_to_user_profile_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user_profile', 'wallet', $this->bigInteger());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user_profile', 'wallet');
    }
}
