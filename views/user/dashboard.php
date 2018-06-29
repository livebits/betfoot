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

                        } else if($action == "user-charge"){
                            echo 'شارژ حساب کاربر';

                        } else if($action == "history"){
                            echo 'سابقه پیشبینی';

                        }  else if($action == "transactions"){
                            echo 'سابقه تراکنش ها';

                        } else if($action == "withdraw"){
                            echo 'درخواست برداشت';

                        } else if($action == "message"){
                            echo 'ارسال پیام';

                        } else if($action == "messages"){
                            echo 'پیام های من';

                        } else if($action == "forget"){
                            echo 'تغییر کلمه عبور';

                        } else if($action == "site-account"){
                            echo 'خلاصه حساب سایت';

                        } else if($action == "users"){
                            echo 'مدیریت کاربران';

                        } else if($action == "users-history"){
                            echo 'پیشبینی کاربران';

                        } else if($action == "users-transactions"){
                            echo 'تراکنش های کاربران';

                        } else if($action == "users-withdraw"){
                            echo 'درخواست های برداشت';

                        } else if($action == "users-messages"){
                            echo 'پیام های کاربران';

                        } else if($action == "reply-message"){
                            echo 'پاسخ پیام';

                        } else if($action == "agents"){
                            echo 'طرح نمایندگی';

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

                        } else if($action == "user-charge"){
                            echo $this->render('user-charge', compact('params'));

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

                        } else if($action == "site-account"){
                            echo $this->render('site-account', compact('params'));

                        } else if($action == "users"){
                            echo $this->render('users', compact('params'));

                        } else if($action == "users-history"){
                            echo $this->render('users-history', compact('params'));

                        } else if($action == "users-transactions"){
                            echo $this->render('users-transactions', compact('params'));

                        } else if($action == "users-withdraw"){
                            echo $this->render('users-withdraw', compact('params'));

                        } else if($action == "users-messages"){
                            echo $this->render('users-messages', compact('params'));

                        } else if($action == "agents"){
                            echo $this->render('agents', compact('params'));

                        } else if($action == "reply-message"){
                            echo $this->render('reply-message', compact('params'));

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

                    <?php
                        $session = Yii::$app->session;
                        $isAdmin = $session->get('isAdmin');
                    ?>

                    <?php
                        if($isAdmin){
                            ?>
                            <div class="dash-menu-btn">
                                <a <?php if($action == "site-account" || $action == "") {  ?> class="active" <?php } ?> href="<?php echo Yii::$app->getUrlManager()->createUrl('user'); ?>?action=site-account">
                                    خلاصه حساب سایت
                                </a>
                            </div>
                            <div class="menu-divider"></div>

                            <div class="dash-menu-btn">
                                <a <?php if($action == "users") {  ?> class="active" <?php } ?> href="<?php echo Yii::$app->getUrlManager()->createUrl('user'); ?>?action=users">
                                    مدیریت کاربران
                                </a>
                            </div>
                            <div class="menu-divider"></div>

                            <div class="dash-menu-btn">
                                <a <?php if($action == "user-charge") {  ?> class="active" <?php } ?> href="<?php echo Yii::$app->getUrlManager()->createUrl('user'); ?>?action=user-charge">
                                    شارژ حساب کاربر
                                </a>
                            </div>
                            <div class="menu-divider"></div>

                            <div class="dash-menu-btn">
                                <a <?php if($action == "users-history") {  ?> class="active" <?php } ?> href="<?php echo Yii::$app->getUrlManager()->createUrl('user'); ?>?action=users-history">
                                    پیشبینی کاربران
                                </a>
                            </div>
                            <div class="menu-divider"></div>

                            <div class="dash-menu-btn">
                                <a <?php if($action == "users-transactions") {  ?> class="active" <?php } ?> href="<?php echo Yii::$app->getUrlManager()->createUrl('user'); ?>?action=users-transactions">
                                     تراکنش های کاربران
                                </a>
                            </div>
                            <div class="menu-divider"></div>

                            <div class="dash-menu-btn">
                                <a <?php if ($action == "users-withdraw") { ?> class="active" <?php } ?>
                                        href="<?php echo Yii::$app->getUrlManager()->createUrl('user'); ?>?action=users-withdraw">
                                    درخواست های برداشت
                                </a>
                            </div>
                            <div class="menu-divider"></div>

                            <div class="dash-menu-btn">
                                <a <?php if ($action == "users-messages") { ?> class="active" <?php } ?>
                                        href="<?php echo Yii::$app->getUrlManager()->createUrl('user'); ?>?action=users-messages">
                                    پیام های کاربران
                                </a>
                            </div>
                            <div class="menu-divider"></div>

                    <?php
                        }
                    ?>

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

                    <?php
                    if(!$isAdmin) {
                        ?>
                        <div class="dash-menu-btn">
                            <a <?php if ($action == "withdraw") { ?> class="active" <?php } ?>
                                    href="<?php echo Yii::$app->getUrlManager()->createUrl('user'); ?>?action=withdraw">
                                درخواست برداشت
                            </a>
                        </div>
                        <div class="menu-divider"></div>
                        <?php
                    }
                    ?>

                    <?php
                    if(!$isAdmin) {
                        ?>
                        <div class="dash-menu-btn">
                            <a <?php if ($action == "message") { ?> class="active" <?php } ?>
                                    href="<?php echo Yii::$app->getUrlManager()->createUrl('user'); ?>?action=message">
                                ارسال پیام
                            </a>
                        </div>
                        <div class="menu-divider"></div>
                        <?php
                    }
                    ?>

                    <?php
                    if(!$isAdmin) {
                        ?>
                        <div class="dash-menu-btn">
                            <a <?php if ($action == "messages") { ?> class="active" <?php } ?>
                                    href="<?php echo Yii::$app->getUrlManager()->createUrl('user'); ?>?action=messages">
                                پیام های من
                            </a>
                        </div>
                        <div class="menu-divider"></div>
                        <?php
                    }
                        ?>

                    <div class="dash-menu-btn">
                        <a <?php if ($action == "agents") { ?> class="active" <?php } ?>
                                href="<?php echo Yii::$app->getUrlManager()->createUrl('user'); ?>?action=agents">
                            طرح نمایندگی
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