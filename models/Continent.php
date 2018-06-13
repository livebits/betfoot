<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "continent".
 *
 * @property int $id
 * @property int $continent_id
 * @property string $name
 */
class Continent extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'continent';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['continent_id'], 'integer'],
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
            'continent_id' => 'Continent ID',
            'name' => 'Name',
        ];
    }

    public function getCountries()
    {
        return $this->hasMany(Country::className(), ['continent_id' => 'continent_id']);
    }
}
