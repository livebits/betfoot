<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "withdraw".
 *
 * @property int $id
 * @property int $user_id
 * @property int $price
 * @property string $account_owner
 * @property string $bank_name
 * @property string $account_number
 * @property string $card_number
 * @property string $shaba_number
 * @property string $status
 * @property int $updated_at
 * @property int $created_at
 *
 * @property User $user
 */
class Withdraw extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'withdraw';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'price', 'updated_at', 'created_at'], 'integer'],
            [['account_owner', 'bank_name', 'account_number', 'card_number', 'shaba_number', 'status'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'price' => 'Price',
            'account_owner' => 'Account Owner',
            'bank_name' => 'Bank Name',
            'account_number' => 'Account Number',
            'card_number' => 'Card Number',
            'shaba_number' => 'Shaba Number',
            'status' => 'Status',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
