<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_wallet".
 *
 * @property int $id
 * @property int $user_id
 * @property int $amount
 * @property string $type
 * @property string $comment
 * @property string $ip
 * @property int $created_at
 *
 * @property User $user
 */
class UserWallet extends \yii\db\ActiveRecord
{
    public static $WITHDRAW = 'WITHDRAW';
    public static $DEPOSIT = 'DEPOSIT';
    public static $PREDICT = 'PREDICT';
    public static $WIN = 'WIN';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_wallet';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'amount', 'created_at'], 'integer'],
            [['type', 'comment', 'ip'], 'string', 'max' => 255],
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
            'amount' => 'Amount',
            'type' => 'Type',
            'comment' => 'Comment',
            'ip' => 'Ip',
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
