<?php

use yii\db\Migration;

/**
 * Handles the creation of table `season`.
 */
class m180601_203027_create_season_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('season', [
            'id' => $this->primaryKey(),
            'season_id' => $this->integer(),
            'name' => $this->string(),
            'is_current_season' => $this->boolean(),
            'current_round_id' => $this->integer(),
            'current_stage_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('season');
    }
}
