<?php

use yii\db\Migration;

/**
 * Handles the creation of table `fixture`.
 */
class m180601_145303_create_fixture_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('fixture', [
            'id' => $this->primaryKey(),
            'score_id' => $this->integer(),
            'league_id' => $this->integer(),
            'season_id' => $this->integer(),
            'stage_id' => $this->integer(),
            'round_id' => $this->integer(),
            'group_id' => $this->integer(),
            'aggregate_id' => $this->integer(),
            'venue_id' => $this->integer(),
            'referee_id' => $this->integer(),
            'localteam_id' => $this->integer(),
            'visitorteam_id' => $this->integer(),
            'commentaries' => $this->string(512),
            'winning_odds_calculated' => $this->boolean(),
            'localteam_formation' => $this->string(),
            'visitorteam_formation' => $this->string(),
            'localteam_score' => $this->string(),
            'visitorteam_score' => $this->string(),
            'localteam_pen_score' => $this->string(),
            'visitorteam_pen_score' => $this->string(),
            'ht_score' => $this->string(),
            'ft_score' => $this->string(),
            'et_score' => $this->string(),
            'status' => $this->string(),
            'starting_at' => $this->dateTime(),
            'starting_at_ts' => $this->integer(),
            'starting_at_timezone' => $this->string(),
            'minute' => $this->integer(),
            'second' => $this->integer(),
            'added_time' => $this->integer(),
            'extra_minute' => $this->integer(),
            'injury_time' => $this->integer(),
            'localteam_coach_id' => $this->integer(),
            'visitorteam_coach_id' => $this->integer(),
            'localteam_position' => $this->integer(),
            'visitorteam_position' => $this->integer(),
            'deleted' => $this->boolean(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('fixture');
    }
}
