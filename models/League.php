<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "league".
 *
 * @property int $id
 * @property int $league_id
 * @property int $legacy_id
 * @property int $country_id
 * @property string $name
 * @property int $is_cup
 * @property int $current_season_id
 * @property int $current_round_id
 * @property int $current_stage_id
 * @property int $live_standings
 * @property int $topscorer_goals
 * @property int $topscorer_assists
 * @property int $topscorer_cards
 */
class League extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'league';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['league_id', 'legacy_id', 'country_id', 'is_cup', 'current_season_id', 'current_round_id', 'current_stage_id', 'live_standings', 'topscorer_goals', 'topscorer_assists', 'topscorer_cards'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'league_id' => 'League ID',
            'legacy_id' => 'Legacy ID',
            'country_id' => 'Country ID',
            'name' => 'Name',
            'is_cup' => 'Is Cup',
            'current_season_id' => 'Current Season ID',
            'current_round_id' => 'Current Round ID',
            'current_stage_id' => 'Current Stage ID',
            'live_standings' => 'Live Standings',
            'topscorer_goals' => 'Topscorer Goals',
            'topscorer_assists' => 'Topscorer Assists',
            'topscorer_cards' => 'Topscorer Cards',
        ];
    }
}
