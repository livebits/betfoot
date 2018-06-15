<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fixture".
 *
 * @property int $id
 * @property int $fixture_id
 * @property int $league_id
 * @property int $season_id
 * @property int $stage_id
 * @property int $round_id
 * @property int $group_id
 * @property int $aggregate_id
 * @property int $venue_id
 * @property int $referee_id
 * @property int $localteam_id
 * @property int $visitorteam_id
 * @property string $commentaries
 * @property int $winning_odds_calculated
 * @property string $localteam_formation
 * @property string $visitorteam_formation
 * @property string $localteam_score
 * @property string $visitorteam_score
 * @property string $localteam_pen_score
 * @property string $visitorteam_pen_score
 * @property string $ht_score
 * @property string $ft_score
 * @property string $et_score
 * @property string $status
 * @property string $starting_at
 * @property int $starting_at_ts
 * @property string $starting_at_timezone
 * @property int $minute
 * @property int $second
 * @property int $added_time
 * @property int $extra_minute
 * @property int $injury_time
 * @property int $localteam_coach_id
 * @property int $visitorteam_coach_id
 * @property int $localteam_position
 * @property int $visitorteam_position
 * @property int $deleted
 */
class Fixture extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fixture';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fixture_id', 'league_id', 'season_id', 'stage_id', 'round_id', 'group_id', 'aggregate_id', 'venue_id', 'referee_id', 'localteam_id', 'visitorteam_id', 'winning_odds_calculated', 'starting_at_ts', 'minute', 'second', 'added_time', 'extra_minute', 'injury_time', 'localteam_coach_id', 'visitorteam_coach_id', 'localteam_position', 'visitorteam_position', 'deleted'], 'integer'],
            [['starting_at'], 'safe'],
            [['commentaries'], 'string', 'max' => 512],
            [['localteam_formation', 'visitorteam_formation', 'localteam_score', 'visitorteam_score', 'localteam_pen_score', 'visitorteam_pen_score', 'ht_score', 'ft_score', 'et_score', 'status', 'starting_at_timezone'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fixture_id' => 'Score ID',
            'league_id' => 'League ID',
            'season_id' => 'Season ID',
            'stage_id' => 'Stage ID',
            'round_id' => 'Round ID',
            'group_id' => 'Group ID',
            'aggregate_id' => 'Aggregate ID',
            'venue_id' => 'Venue ID',
            'referee_id' => 'Referee ID',
            'localteam_id' => 'Localteam ID',
            'visitorteam_id' => 'Visitorteam ID',
            'commentaries' => 'Commentaries',
            'winning_odds_calculated' => 'Winning Odds Calculated',
            'localteam_formation' => 'Localteam Formation',
            'visitorteam_formation' => 'Visitorteam Formation',
            'localteam_score' => 'Localteam Score',
            'visitorteam_score' => 'Visitorteam Score',
            'localteam_pen_score' => 'Localteam Pen Score',
            'visitorteam_pen_score' => 'Visitorteam Pen Score',
            'ht_score' => 'Ht Score',
            'ft_score' => 'Ft Score',
            'et_score' => 'Et Score',
            'status' => 'Status',
            'starting_at' => 'Starting At',
            'starting_at_ts' => 'Starting At Ts',
            'starting_at_timezone' => 'Starting At Timezone',
            'minute' => 'Minute',
            'second' => 'Second',
            'added_time' => 'Added Time',
            'extra_minute' => 'Extra Minute',
            'injury_time' => 'Injury Time',
            'localteam_coach_id' => 'Localteam Coach ID',
            'visitorteam_coach_id' => 'Visitorteam Coach ID',
            'localteam_position' => 'Localteam Position',
            'visitorteam_position' => 'Visitorteam Position',
            'deleted' => 'Deleted',
        ];
    }

    public function getLocalTeam()
    {
        return $this->hasOne(Team::className(), ['team_id' => 'localteam_id']);
    }

    public function getVisitorTeam()
    {
        return $this->hasOne(Team::className(), ['team_id' => 'visitorteam_id']);
    }

    public function getLeague()
    {
        return $this->hasOne(League::className(), ['league_id' => 'league_id']);
    }

    public function getSeason()
    {
        return $this->hasOne(Season::className(), ['season_id' => 'season_id']);
    }

    public function getOdds(){
        return $this->hasMany(Odds::className(), ['fixture_id' => 'fixture_id']);
    }
}
