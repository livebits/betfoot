<?php

use yii\db\Migration;

/**
 * Handles the creation of table `continent`.
 */
class m180601_115422_create_continent_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('continent', [
            'id' => $this->primaryKey(),
            'continent_id' => $this->integer(),
            'name' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('continent');
    }
}
