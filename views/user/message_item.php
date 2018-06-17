<?php

use yii\helpers\Html;

?>
<div style="">
    <div style="width: 100%;background-color: #333333;
height: 30px;line-height: 30px;padding: 0px 10px;">

        <div style="float: right"><?= $model->subject ?></div>
        <div style="float: left"><?= \app\components\Jdf::jdate('Y/m/d H:i:s', $model->created_at); ?></div>

    </div>
    <div style="width: 100%;background-color: #eeeeee;height: auto;margin-bottom: 20px;color: black;padding: 10px 20px;">
        <?= $model->message ?>
    </div>
</div>