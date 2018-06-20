<?php

use yii\db\Migration;

/**
 * Handles adding wallet to table `user_profile`.
 */
class m180619_222448_add_moaref_column_to_user_profile_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user_profile', 'reagent_code', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user_profile', 'reagent_code');
    }
}
