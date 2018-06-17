<?php

use webvimark\modules\UserManagement\UserManagementModule;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use webvimark\modules\UserManagement\models\User;
use webvimark\modules\UserManagement\models\forms\ChangeOwnPasswordForm;

/**
 * @var yii\web\View $this
 * @var webvimark\modules\UserManagement\models\forms\ChangeOwnPasswordForm $model
 */

$user = User::getCurrentUser();

$model = new ChangeOwnPasswordForm(['user'=>$user]);
?>
<style>
    div.form-group label.control-label {
        float: right;
    }

    div.form-group div.col-sm-6 {
        float: right;
    }
</style>

<?php if ( Yii::$app->session->hasFlash('success') ): ?>
    <div class="alert alert-success text-center">
        <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php endif; ?>

<div class="user-form" style="padding-top: 20px;padding-right: 20px;">

    <?php $form = ActiveForm::begin([
        'action'=> Yii::$app->getUrlManager()->createUrl('user-management/auth/change-own-password'),
        'id'=>'user',
        'layout'=>'horizontal',
        'validateOnBlur'=>false,
    ]); ?>

    <?php if ( $model->scenario != 'restoreViaEmail' ): ?>

        <?= $form->field($model, 'current_password')
            ->passwordInput(['maxlength' => 255, 'autocomplete'=>'off'])?>

    <?php endif; ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => 255, 'autocomplete'=>'off']) ?>

    <?= $form->field($model, 'repeat_password')->passwordInput(['maxlength' => 255, 'autocomplete'=>'off']) ?>


    <div class="form-group" style="margin-top: 10px;">
        <div class="col-sm-3"></div>
        <div class="col-sm-6" style="float: left;">
            <?= Html::submitButton(
                '<span class="glyphicon glyphicon-ok"></span> ' . UserManagementModule::t('back', 'Save'),
                ['class' => 'btn btn-success btn-block']
            ) ?>
        </div>
        <div class="col-sm-3"></div>
    </div>

    <?php ActiveForm::end(); ?>
</div>