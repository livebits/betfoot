<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "odds".
 *
 * @property int $id
 * @property int $fixture_id
 * @property int $odds_id
 * @property string $name
 * @property string $bookmaker
 */
class Odds extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'odds';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fixture_id', 'odds_id'], 'integer'],
            [['bookmaker'], 'string'],
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
            'fixture_id' => 'Fixture ID',
            'odds_id' => 'Odds ID',
            'name' => 'Name',
            'bookmaker' => 'Bookmaker',
        ];
    }
}
