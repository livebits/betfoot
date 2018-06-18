<?php

use yii\helpers\Html;

?>

<div style="">
    <div style="width: 100%;background-color: #333333;
height: 30px;line-height: 30px;padding: 0px 10px;">

        <div style="float: right"><?php
            if(isset($model['firstName'])){
                echo  $model['firstName'] . ' ' . $model['lastName'];
            }
            ?>
        </div>
        <div style="float: left"><?= \app\components\Jdf::jdate('Y/m/d H:i:s', $model['created_at']); ?></div>

    </div>
    <div style="width: 100%;background-color: #eeeeee;height: auto;margin-bottom: 20px;color: black;padding: 10px 20px;">
        <ul>
            <li><?= 'هزینه درخواستی: ' .$model['price'] ?></li>
            <li><?= 'نام مالک: ' .$model['account_owner'] ?></li>
            <li><?= 'نام بانک: ' .$model['bank_name'] ?></li>
            <li><?= 'شماره حساب: ' .$model['account_number'] ?></li>
            <li><?= 'شماره کارت: ' .$model['card_number'] ?></li>
            <li><?= 'شماره شبا: ' .$model['shaba_number'] ?></li>
            <li><?= 'تاریخ درخواست: ' .\app\components\Jdf::jdate('Y/m/d H:i:s', $model['created_at']); ?></li>
        </ul>
    </div>
</div>