<?php

use yii\helpers\Html;

?>

<div style="">
    <div style="width: 100%;background-color: #333333;
height: 50px;line-height: 50px;padding: 0px 10px;">

        <div style="float: right"><?php
            echo $model['subject'];
            if(isset($model['firstName'])){
                echo ' ( ' . $model['firstName'] . ' ' . $model['lastName'] . ' ) ';
            }
            ?>
        </div>
        <div style="float: left">
            <?= \app\components\Jdf::jdate('Y/m/d H:i:s', $model['created_at']); ?>
        </div>

    </div>
    <div style="width: 100%;background-color: #eeeeee;height: auto;margin-bottom: 20px;color: black;padding: 10px 20px;">
        <?= $model['message'] ?>
    </div>
    <?php
        if(isset($model['status'])) {

            $reply_messages = \app\models\Message::find()->where('parent_id=' . $model['id'])->all();

            foreach ($reply_messages as $reply_message) {
                ?>

                <div style="width: 95%;background-color: #333;height: auto;margin-right: 20px;color: white;padding: 5px;">پاسخ ادمین</div>
                <div style="width: 95%;background-color: #eeeeee;height: auto;margin-bottom: 20px;margin-right: 20px;color: black;padding: 10px 20px;">
                    <?= $reply_message->message; ?>
                </div>

                <?php
            }
        }
    ?>
</div>