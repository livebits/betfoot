<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bookmaker".
 *
 * @property int $id
 * @property int $bookmaker_id
 * @property string $name
 * @property string $logo
 */
class Bookmaker extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bookmaker';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bookmaker_id'], 'integer'],
            [['name', 'logo'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bookmaker_id' => 'Bookmaker ID',
            'name' => 'Name',
            'logo' => 'Logo',
        ];
    }
}
