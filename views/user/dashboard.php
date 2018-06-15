<?php
/* @var $this yii\web\View */

?>
    <div class="container center-content">

        <div class="col-md-1"></div>
        <div class="col-md-8 leftbar">

            <div class="box">
                <div class="header">

                    <div class="header-container">

                        <?php

                        if($action == "charge"){
                            echo 'شارژ حساب';

                        } else if($action == "account" || $action == ""){
                            echo 'خلاصه حساب';

                        } else if($action == "history"){
                            echo 'سابقه پیشبینی';

                        }  else if($action == "transactions"){
                            echo 'سابقه تراکنش ها';

                        } else if($action == "withdraw"){
                            echo 'درخواست برداشت';

                        } else if($action == "message"){
                            echo 'ارسال پیام';

                        } else if($action == "messages"){
                            echo 'پیام های دریافتی';

                        } else if($action == "forget"){
                            echo 'تغییر کلمه عبور';

                        }
                        ?>

                    </div>
                </div>
                <div class="body">

                    <?php

                        if($action == "charge"){
                            echo $this->render('charge-account', compact('params'));

                        } else if($action == "account" || $action == ""){
                            echo $this->render('account-info', compact('params'));

                        } else if($action == "history"){
                            echo $this->render('history', compact('params'));

                        }  else if($action == "transactions"){
                            echo $this->render('transactions', compact('params'));

                        } else if($action == "withdraw"){
                            echo $this->render('withdraw-form', compact('params'));

                        } else if($action == "message"){
                            echo $this->render('message', compact('params'));

                        } else if($action == "messages"){
                            echo $this->render('messages', compact('params'));

                        } else if($action == "forget"){
                            echo $this->render('forget-pass', compact('params'));

                        }
                    ?>

                </div>
            </div>
        </div>
        <div class="col-md-2 rightbar">

            <div class="box">
                <div class="header">

                    <div class="header-container">
                        منو
                    </div>
                </div>
                <div class="body">

                    <div class="dash-menu-btn">
                        <a <?php if($action == "account" || $action == "") {  ?> class="active" <?php } ?> href="<?php echo Yii::$app->getUrlManager()->createUrl('user'); ?>?action=account">
                            خلاصه حساب
                        </a>
                    </div>
                    <div class="menu-divider"></div>

                    <div class="dash-menu-btn">
                        <a <?php if($action == "charge") {  ?> class="active" <?php } ?> href="<?php echo Yii::$app->getUrlManager()->createUrl('user'); ?>?action=charge">
                        شارژ حساب
                        </a>
                    </div>
                    <div class="menu-divider"></div>

                    <div class="dash-menu-btn">
                        <a <?php if($action == "history") {  ?> class="active" <?php } ?> href="<?php echo Yii::$app->getUrlManager()->createUrl('user'); ?>?action=history">
                            سابقه پیشبینی
                        </a>
                    </div>
                    <div class="menu-divider"></div>

                    <div class="dash-menu-btn">
                        <a <?php if($action == "transactions") {  ?> class="active" <?php } ?> href="<?php echo Yii::$app->getUrlManager()->createUrl('user'); ?>?action=transactions">
                            سابقه تراکنش ها
                        </a>
                    </div>
                    <div class="menu-divider"></div>

                    <div class="dash-menu-btn">
                        <a <?php if($action == "withdraw") {  ?> class="active" <?php } ?> href="<?php echo Yii::$app->getUrlManager()->createUrl('user'); ?>?action=withdraw">
                            درخواست برداشت
                        </a>
                    </div>
                    <div class="menu-divider"></div>

                    <div class="dash-menu-btn">
                        <a <?php if($action == "message") {  ?> class="active" <?php } ?> href="<?php echo Yii::$app->getUrlManager()->createUrl('user'); ?>?action=message">
                            ارسال پیام
                        </a>
                    </div>
                    <div class="menu-divider"></div>

                    <div class="dash-menu-btn">
                        <a <?php if($action == "messages") {  ?> class="active" <?php } ?> href="<?php echo Yii::$app->getUrlManager()->createUrl('user'); ?>?action=messages">
                            پیام های دریافتی
                        </a>
                    </div>
                    <div class="menu-divider"></div>

                    <div class="dash-menu-btn">
                        <a <?php if($action == "forget") {  ?> class="active" <?php } ?> href="<?php echo Yii::$app->getUrlManager()->createUrl('user'); ?>?action=forget">
                            تغییر کلمه عبور
                        </a>
                    </div>

                </div>
            </div>


        </div>
        <div class="col-md-1"></div>
    </div>