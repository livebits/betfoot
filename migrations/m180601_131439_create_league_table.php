<?php

use yii\db\Migration;

/**
 * Handles the creation of table `league`.
 */
class m180601_131439_create_league_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('league', [
            'id' => $this->primaryKey(),
            'league_id' => $this->integer(),
            'legacy_id' => $this->integer(),
            'country_id' => $this->integer(),
            'name' => $this->string(),
            'is_cup' => $this->boolean(),
            'current_season_id' => $this->integer(),
            'current_round_id' => $this->integer(),
            'current_stage_id' => $this->integer(),
            'live_standings' => $this->boolean(),
            'topscorer_goals' => $this->boolean(),
            'topscorer_assists' => $this->boolean(),
            'topscorer_cards' => $this->boolean(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('league');
    }
}
