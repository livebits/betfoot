<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "prediction".
 *
 * @property int $id
 * @property int $user_id
 * @property int $selected_team_id
 * @property int $fixture_id
 * @property int $user_price
 * @property int $win_price
 * @property string $status
 * @property int $updated_at
 * @property int $created_at
 *
 * @property User $user
 */
class Prediction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prediction';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'selected_team_id', 'fixture_id', 'user_price', 'win_price', 'updated_at', 'created_at'], 'integer'],
            [['status'], 'string', 'max' => 255],
//            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'selected_team_id' => 'نوع شرط',
            'fixture_id' => 'Fixture ID',
            'user_price' => 'مبلغ شرط',
            'win_price' => 'مبلغ برد',
            'status' => 'وضعیت پیشبینی',
            'updated_at' => 'Updated At',
            'created_at' => 'زمان پیشبینی',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getFixture()
    {
        return $this->hasOne(Fixture::className(), ['fixture_id' => 'fixture_id']);
    }
}
