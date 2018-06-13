<?php

namespace app\models;


use webvimark\modules\UserManagement\models\forms\RegistrationForm;
use webvimark\modules\UserManagement\models\User;
use webvimark\modules\UserManagement\UserManagementModule;
use yii\helpers\ArrayHelper;
use Yii;

class RegistrationFormWithProfile extends RegistrationForm
{
    public $firstName;
    public $lastName;
    public $mobile;

    /**
     * @return array
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['firstName', 'lastName', 'mobile'], 'required'],
            [['firstName', 'lastName', 'mobile'], 'string'],
            [['firstName', 'lastName', 'mobile'], 'trim'],
            [['firstName', 'lastName', 'mobile'], 'purgeXSS'],
        ]);
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'firstName' => 'نام',
            'lastName' => 'نام خانوادگی',
            'mobile' => 'شماره موبایل',
        ]);
    }

    public function registerUser($performValidation = true){
        $validations = $this->validateProfile();
        if ($validations == null) {
            parent::registerUser($performValidation);
        } else {
            foreach ($validations as $validation_key => $validation_value) {
                $this->addError($validation_key, $validation_value[0]);
            }
        }
    }

    public function validateProfile(){
        $model = new UserProfile();

        $model->firstName = $this->firstName;
        $model->lastName = $this->lastName;
        $model->mobile = $this->mobile;

        if ($model->validate()) {
            return null;
        } else {
            // validation failed: $errors is an array containing error messages
            $errors = $model->errors;
            return $errors;
        }
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

        $model->firstName = $this->firstName;
        $model->lastName = $this->lastName;
        $model->mobile = $this->mobile;

        $model->created_at = time();

        $model->save(false);
    }
}