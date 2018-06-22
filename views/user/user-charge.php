<?php
/* @var $this yii\web\View */
use yii\bootstrap\ActiveForm;
use yii\jui\AutoComplete;
use yii\web\JsExpression;

$data = (new \yii\db\Query())
    ->select(['user.username as value', 'user.username as  label','user.id as id'])
    ->from('user')
    ->leftJoin('user_profile', 'user_profile.user_id=user.id')
//    ->asArray()
    ->all();

?>

<div class="charge-box">

    <?php
        if ($params == "ok") {
            ?>

            <div class="alert alert-success" role="alert">پرداخت با موفقیت انجام شد و به شارژ کاربر افزوده شد.</div>

            <?php
        } else if ($params == "nok") {
            ?>

            <div class="alert alert-danger" role="alert">پرداخت با خطا رو به رو شد، لطفا مجددا تلاش بفرمایید.</div>

            <?php
        } else if ($params == "charge") {
            ?>

            <div class="alert alert-danger" role="alert">اعتبار کیف پول کافی نیست، ابتدا حساب خود را شارژ کنید. </div>

            <?php
        }
    ?>
    <p>
        برای شارژ حساب ایمیل کاربر مورد نظر را وارد کرده و
        مبلغ مورد نظر خود را در فرم زیر وارد کنید و کلید پرداخت را بزنید.
    </p>

    <?php $form = ActiveForm::begin([
        'action' => '/payment/charge',
        'method' => 'post',
        'id'      => 'payment-form',
        'action'  => Yii::$app->getUrlManager()->createUrl('payment/charge'),
        'validateOnBlur'=>false,
    ]) ?>

    <div class="input-group" style="">
        <span class="input-group-addon" id="sizing-addon2">
            ایمیل کاربر
        </span>

        <?php echo AutoComplete::widget([
            'name' => 'user_name',
            'id' => 'ddd',
            'clientOptions' => [
                'source' => $data,
                'minLength'=>'3',
                'autoFill'=>true,
                'select' => new JsExpression("function( event, ui ) {
			        $('#memberssearch-family_name_id').val(ui.item.id);//#memberssearch-family_name_id is the id of hiddenInput.
			     }")],
            'options' => [
                'class' => 'form-control',
                'required' => 'required',
                'placeholder' => 'ایمیل کاربر را وارد کنید',
            ]
        ]); ?>

    </div>

    <div class="input-group" style="margin-top: 10px;">
        <span class="input-group-addon" id="sizing-addon2">
            مبلغ به تومان
        </span>
        <input type="number" name="amount" class="form-control" aria-describedby="sizing-addon2">
    </div>

    <div style="margin: 10px auto; width: 400px;">
        <button type="submit" class="btn btn-block btn-success">شارژ حساب</button>
    </div>

    <?php ActiveForm::end() ?>

</div>
