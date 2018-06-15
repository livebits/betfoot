<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "country".
 *
 * @property int $id
 * @property int $country_id
 * @property int $continent_id
 * @property string $name
 * @property string $sub_region
 * @property string $world_region
 * @property string $fifa
 * @property string $iso
 * @property string $longitude
 * @property string $latitude
 * @property string $flag
 */
class Country extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'country';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['country_id', 'continent_id'], 'integer'],
            [['longitude', 'latitude'], 'number'],
            [['name', 'sub_region', 'world_region', 'fifa', 'iso', 'flag'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'country_id' => 'Country ID',
            'continent_id' => 'Continent ID',
            'name' => 'Name',
            'sub_region' => 'Sub Region',
            'world_region' => 'World Region',
            'fifa' => 'Fifa',
            'iso' => 'Iso',
            'longitude' => 'Longitude',
            'latitude' => 'Latitude',
            'flag' => 'Flag',
        ];
    }

    public function getContinent()
    {
        return $this->hasOne(Continent::className(), ['continent_id' => 'continent_id']);
    }
}
