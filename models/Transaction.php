<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transaction".
 *
 * @property int $id
 * @property int $user_id
 * @property string $amount
 * @property string $authority
 * @property string $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $user
 */
class Transaction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transaction';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'amount', 'created_at', 'updated_at'], 'integer'],
            [['authority', 'status'], 'string', 'max' => 255]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'کد کاربر',
            'amount' => 'مبلغ (تومان)',
            'authority' => 'Authority',
            'status' => 'وضعیت',
            'created_at' => 'تاریخ انجام',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /*
     * Transactions status
     *
     * started
     * nok
     * ok
     */
}
