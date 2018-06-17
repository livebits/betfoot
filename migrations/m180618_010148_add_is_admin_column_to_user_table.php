<?php

use yii\db\Migration;

/**
 * Handles adding wallet to table `user`.
 */
class m180618_010148_add_is_admin_column_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'isAdmin', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'isAdmin');
    }
}
