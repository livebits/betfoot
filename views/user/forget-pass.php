<?php
//
//use webvimark\modules\UserManagement\UserManagementModule;
//use yii\bootstrap\ActiveForm;
//use yii\helpers\Html;
//use webvimark\modules\UserManagement\models\User;
//use webvimark\modules\UserManagement\models\forms\ChangeOwnPasswordForm;
//
///**
// * @var yii\web\View $this
// * @var webvimark\modules\UserManagement\models\forms\ChangeOwnPasswordForm $model
// */
//
//$user = User::getCurrentUser();
//
//$model = new ChangeOwnPasswordForm(['user'=>$user]);
//?>
<!--<div class="change-own-password">-->
<!---->
<!--    <h2 class="lte-hide-title">--><?//= $this->title ?><!--</h2>-->
<!---->
<!--    <div class="panel panel-default">-->
<!--        <div class="panel-body">-->
<!---->
<!--            --><?php //if ( Yii::$app->session->hasFlash('success') ): ?>
<!--                <div class="alert alert-success text-center">-->
<!--                    --><?//= Yii::$app->session->getFlash('success') ?>
<!--                </div>-->
<!--            --><?php //endif; ?>
<!---->
<!--            <div class="user-form">-->
<!---->
<!--                --><?php //$form = ActiveForm::begin([
//                    'action'=> Yii::$app->getUrlManager()->createUrl('user-management/auth/change-own-password'),
//                    'id'=>'user',
//                    'layout'=>'horizontal',
//                    'validateOnBlur'=>false,
//                ]); ?>
<!---->
<!--                --><?php //if ( $model->scenario != 'restoreViaEmail' ): ?>
<!--                    --><?//= $form->field($model, 'current_password')->passwordInput(['maxlength' => 255, 'autocomplete'=>'off']) ?>
<!---->
<!--                --><?php //endif; ?>
<!---->
<!--                --><?//= $form->field($model, 'password')->passwordInput(['maxlength' => 255, 'autocomplete'=>'off']) ?>
<!---->
<!--                --><?//= $form->field($model, 'repeat_password')->passwordInput(['maxlength' => 255, 'autocomplete'=>'off']) ?>
<!---->
<!---->
<!--                <div class="form-group">-->
<!--                    <div class="col-sm-offset-3 col-sm-9">-->
<!--                        --><?//= Html::submitButton(
//                            '<span class="glyphicon glyphicon-ok"></span> ' . UserManagementModule::t('back', 'Save'),
//                            ['class' => 'btn btn-primary']
//                        ) ?>
<!--                    </div>-->
<!--                </div>-->
<!---->
<!--                --><?php //ActiveForm::end(); ?>
<!---->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!---->
<!--</div>-->
