<?php
/**
 * @var $this yii\web\View
 * @var $model webvimark\modules\UserManagement\models\forms\LoginForm
 */

use webvimark\modules\UserManagement\components\GhostHtml;
use webvimark\modules\UserManagement\UserManagementModule;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = "ورود به حساب کاربری";
?>

<div class="container" id="login-wrapper">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">ورود به حساب کاربری</h3>
				</div>
				<div class="panel-body">

					<?php $form = ActiveForm::begin([
						'id'      => 'login-form',
						'options'=>['autocomplete'=>'off'],
						'validateOnBlur'=>false,
						'fieldConfig' => [
							'template'=>"{input}\n{error}",
						],
					]) ?>

					<?= $form->field($model, 'username')
						->textInput(['placeholder'=>'نام کاربری', 'autocomplete'=>'off']) ?>

					<?= $form->field($model, 'password')
						->passwordInput(['placeholder'=>'رمز عبور', 'autocomplete'=>'off']) ?>

<!--					--><?//= (isset(Yii::$app->user->enableAutoLogin) && Yii::$app->user->enableAutoLogin) ? $form->field($model, 'rememberMe')->checkbox(['value'=>true]) : '' ?>

					<?= Html::submitButton(
						'ورود',
						['class' => 'btn btn-lg btn-primary btn-block']
					) ?>

					<div class="row registration-block" style="margin-top: 10px;">
						<div class="col-sm-12">
							<?= GhostHtml::a(
								"ثبت نام",
								['/user-management/auth/registration']
							) ?>
						</div>
						<div class="col-sm-12 text-right">
							<?= GhostHtml::a(
								'فراموشی رمزعبور',
								['/user-management/auth/password-recovery']
							) ?>
						</div>
					</div>




					<?php ActiveForm::end() ?>
				</div>
			</div>
		</div>
	</div>
</div>