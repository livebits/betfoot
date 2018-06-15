<?php

use yii\db\Migration;

/**
 * Handles the creation of table `country`.
 */
class m180601_114731_create_country_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('country', [
            'id' => $this->primaryKey(),
            'country_id' => $this->integer(),
            'continent_id' => $this->integer(),
            'name' => $this->string(),
            'sub_region' => $this->string(),
            'world_region' => $this->string(),
            'fifa' => $this->string(),
            'iso' => $this->string(),
            'longitude' => $this->decimal(10,6),
            'latitude' => $this->decimal(10,6),
            'flag' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('country');
    }
}
