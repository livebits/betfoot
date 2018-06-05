<?php

use yii\db\Migration;

/**
 * Handles the creation of table `team`.
 */
class m180601_193436_create_team_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('team', [
            'id' => $this->primaryKey(),
            'team_id' => $this->integer(),
            'legacy_id' => $this->integer(),
            'name' => $this->string(),
            'short_code' => $this->string(),
            'twitter' => $this->string(),
            'country_id' => $this->integer(),
            'national_team' => $this->boolean(),
            'founded' => $this->integer(),
            'logo_path' => $this->integer(),
            'venue_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('team');
    }
}
