<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "OddsObject".
 *
 * @property int $label
 * @property int $value
 * @property int $winning
 * @property int $handicap
 * @property int $total
 * @property int $bookmaker_event_id
 * @property string $last_update
 */
class OddsObject extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
//    public static function tableName()
//    {
//        return 'team';
//    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['label', 'value', 'winning', 'handicap', 'total', 'bookmaker_event_id'], 'integer'],
            [['last_update'], 'string', 'max' => 255]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
//        return [
//            'id' => 'ID',
//            'team_id' => 'Team ID',
//            'legacy_id' => 'Legacy ID',
//            'name' => 'Name',
//            'short_code' => 'Short Code',
//            'twitter' => 'Twitter',
//            'country_id' => 'Country ID',
//            'national_team' => 'National Team',
//            'founded' => 'Founded',
//            'logo_path' => 'Logo Path',
//            'venue_id' => 'Venue ID',
//        ];
    }
}
