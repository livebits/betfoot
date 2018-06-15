<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_profile".
 *
 * @property int $id
 * @property int $user_id
 * @property string $firstName
 * @property string $lastName
 * @property string $mobile
 * @property string $wallet
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $user
 */
class UserProfile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_profile';
    }

    public static function updateUserWallet($amount)
    {
        $myProfile = UserProfile::find()->where('user_id=' . Yii::$app->user->id)->one();

        if ($myProfile->wallet){

            $newAmount = $myProfile->wallet + $amount;
        } else {
            $newAmount = $amount;
        }

        UserProfile::updateAll(['wallet' => $newAmount], 'user_id=' . Yii::$app->user->id);

        $userProfile = \app\models\UserProfile::find()
            ->where('user_id=' . Yii::$app->user->id)
            ->asArray()
            ->one();

        if($userProfile){
            $session = Yii::$app->session;
            $session->set('userInfo', $userProfile);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'created_at', 'updated_at'], 'integer'],
            [['firstName', 'lastName', 'mobile'], 'string'],
            [['firstName', 'lastName'], 'string', 'max' => 255],
            [['mobile'], 'string', 'max' => 12],
            [['mobile'], 'unique'],
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
            'firstName' => 'نام',
            'lastName' => 'نام خانوادگی',
            'mobile' => 'موبایل',
            'created_at' => 'Created At',
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
}
