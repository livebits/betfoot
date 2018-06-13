<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "team".
 *
 * @property int $id
 * @property int $team_id
 * @property int $legacy_id
 * @property string $name
 * @property string $short_code
 * @property string $twitter
 * @property int $country_id
 * @property int $national_team
 * @property int $founded
 * @property int $logo_path
 * @property int $venue_id
 */
class Team extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'team';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['team_id', 'legacy_id', 'country_id', 'national_team', 'founded', 'venue_id'], 'integer'],
            [['name', 'short_code', 'twitter', 'logo_path'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'team_id' => 'Team ID',
            'legacy_id' => 'Legacy ID',
            'name' => 'Name',
            'short_code' => 'Short Code',
            'twitter' => 'Twitter',
            'country_id' => 'Country ID',
            'national_team' => 'National Team',
            'founded' => 'Founded',
            'logo_path' => 'Logo Path',
            'venue_id' => 'Venue ID',
        ];
    }
}
