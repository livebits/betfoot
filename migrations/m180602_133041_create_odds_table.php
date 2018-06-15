<?php

use yii\db\Migration;

/**
 * Handles the creation of table `odds`.
 */
class m180602_133041_create_odds_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('odds', [
            'id' => $this->primaryKey(),
            'fixture_id' => $this->integer(),
            'odds_id' => $this->integer(),
            'name' => $this->string(),
            'bookmaker' => $this->text()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('odds');
    }
}
