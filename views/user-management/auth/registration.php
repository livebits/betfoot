<?php

use webvimark\modules\UserManagement\UserManagementModule;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var webvimark\modules\UserManagement\models\forms\RegistrationForm $model
 */

$this->title = 'ثبت نام';
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    div.form-group label.control-label {
        float: right;
    }

    div.form-group div.col-sm-6 {
        float: right;
    }
</style>

<div class="container" id="login-wrapper" style="color: black;">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">ثبت نام</h3>
                </div>
                <div class="panel-body">

                    <?php $form = ActiveForm::begin([
                        'id'=>'user',
                        'layout'=>'horizontal',
                        'validateOnBlur'=>false,
                    ]); ?>

                    <?= $form->field($model, 'firstName') ?>

                    <?= $form->field($model, 'lastName') ?>

                    <?= $form->field($model, 'mobile') ?>

                    <?= $form->field($model, 'reagent') ?>

                    <?= $form->field($model, 'username')->textInput(['maxlength' => 50, 'autocomplete'=>'off', 'autofocus'=>true]) ?>

                    <?= $form->field($model, 'password')->passwordInput(['maxlength' => 255, 'autocomplete'=>'off']) ?>

                    <?= $form->field($model, 'repeat_password')->passwordInput(['maxlength' => 255, 'autocomplete'=>'off']) ?>

                    <?= $form->field($model, 'captcha')->widget(Captcha::className(), [
                        'template' => '<div class="row"><div class="col-sm-3"></div><div class="col-sm-3">{image}</div><div class="col-sm-4">{input}</div><div class="col-sm-2"></div></div>',
                        'captchaAction'=>['/user-management/auth/captcha']
                    ]) ?>

                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9">
                            <?= Html::submitButton(
                                '<span class="glyphicon glyphicon-ok"></span> ' . 'ثبت نام',
                                ['class' => 'btn btn-primary']
                            ) ?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>
