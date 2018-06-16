<?php

use yii\db\Migration;

/**
 * Handles adding wallet to table `prediction`.
 */
class m180616_150148_add_more_desc_column_to_prediction_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('prediction', 'more_desc', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('prediction', 'more_desc');
    }
}
