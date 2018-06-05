<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "season".
 *
 * @property int $id
 * @property int $season_id
 * @property string $name
 * @property int $is_current_season
 * @property int $current_round_id
 * @property int $current_stage_id
 */
class Season extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'season';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['season_id', 'is_current_season', 'current_round_id', 'current_stage_id'], 'integer'],
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
            'season_id' => 'Season ID',
            'name' => 'Name',
            'is_current_season' => 'Is Current Season',
            'current_round_id' => 'Current Round ID',
            'current_stage_id' => 'Current Stage ID',
        ];
    }
}
