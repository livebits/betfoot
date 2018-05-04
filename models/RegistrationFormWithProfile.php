<?php

namespace app\models;


use webvimark\modules\UserManagement\models\forms\RegistrationForm;
use webvimark\modules\UserManagement\models\User;
use webvimark\modules\UserManagement\UserManagementModule;
use yii\helpers\ArrayHelper;
use Yii;

class RegistrationFormWithProfile extends RegistrationForm
{
    public $name;
    public $info;

    /**
     * @return array
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['name', 'info'], 'required'],
            [['info'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['name', 'info'], 'trim'],
            [['name', 'info'], 'purgeXSS'],
        ]);
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'name'=>Yii::t('app', 'Name'),
            'info'=>Yii::t('app', 'Info'),
        ]);
    }


    /**
     * Look in parent class for details
     *
     * @param User $user
     */
    protected function saveProfile($user)
    {
        $model = new UserProfile();

        $model->user_id = $user->id;

        $model->name = $this->name;
        $model->info = $this->info;

        $model->save(false);
    }
}