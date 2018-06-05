<?php

use yii\db\Migration;

/**
 * Handles the creation of table `bookmaker`.
 */
class m180602_130623_create_bookmaker_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('bookmaker', [
            'id' => $this->primaryKey(),
            'bookmaker_id' => $this->integer(),
            'name' => $this->string(),
            'logo' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('bookmaker');
    }
}
