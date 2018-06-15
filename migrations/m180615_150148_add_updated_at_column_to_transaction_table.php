<?php

use yii\db\Migration;

/**
 * Handles adding wallet to table `transaction`.
 */
class m180615_150148_add_updated_at_column_to_transaction_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('transaction', 'updated_at', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('transaction', 'updated_at');
    }
}
