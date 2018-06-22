<?php

/* @var $content string */

use app\assets\AppAsset;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;


AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en"
      class="js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths rtl translated-rtl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?= Yii::$app->homeUrl ?>/images/" type="image/png">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
<!--    <link href="/web/css/bootstrap.min.css" rel="stylesheet">-->
<!--    <link href="/web/css/font-awesome.css" rel="stylesheet">-->
    <?php $this->head() ?>

</head>
<body>
<?php $this->beginBody() ?>


<style type="text/css">
    .contentpanel {
        padding: 20px;
        position: relative;
    }

    .contentpanel::after {
        clear: both;
        display: block;
        content: '';
    }

    .color {
        color: #ffffff;
    }
</style>

<div id="wrapper">
    <nav class="navbar navbar-default navbar-static-top navbar-inverse top-nav">
        <div class="container">

            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Afraa</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                <?php
                if(Yii::$app->user->isGuest) {
                ?>

                <?php $form = ActiveForm::begin([
                    'id'      => 'login-form',
                    'action'  => Yii::$app->getUrlManager()->createUrl('user-management/auth/login'),
                    'options'=>['autocomplete'=>'off'],
                    'validateOnBlur'=>false,
                    'options' => [
                        'class' => 'navbar-form navbar-right'
                     ]
                ]) ?>
                    <div class="form-group">
                        <input type="text" name="LoginForm[username]" class="form-control" placeholder="نام کاربری">
                    </div>
                    <div class="form-group">
                        <input type="password" name="LoginForm[password]" class="form-control" placeholder="رمز عبور">
                    </div>
                    <button type="submit" class="btn btn-success">ورود</button>

                    <a href="<?php echo Yii::$app->getUrlManager()->createUrl('user-management/auth/registration'); ?>">
                        <button type="button" class="btn yellow-btn">ثبت نام!</button>
                    </a>
                <?php ActiveForm::end() ?>
                <?php } else { ?>
                    <div class="navbar-form btn-group">
                        <a class="btn btn-danger" href="<?php echo Yii::$app->getUrlManager()->createUrl('site/logout'); ?>">خروج</a>

                        <a class="btn btn-default" href="<?php echo Yii::$app->getUrlManager()->createUrl('user'); ?>">حساب کاربری</a>
                        <a class="btn btn-default" href="<?php echo Yii::$app->getUrlManager()->createUrl('user?action=charge'); ?>">شارژ حساب</a>
                        <button class="btn btn-default btn-demo">موجودی حساب: <?= isset(Yii::$app->session->get('userInfo')['wallet']) ? Yii::$app->session->get('userInfo')['wallet'] : 0 ?> تومان</button>
                        <button class="btn btn-default btn-demo"><?= Yii::$app->session->get('userInfo')['firstName'] ?> عزیز</button>
                    </div>
                <?php } ?>
            </div><!-- /.navbar-collapse -->
        </div>
    </nav>

    <nav class="navbar navbar-default navbar-static-top navbar-inverse">
        <div class="container">

            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2" aria-expanded="false">
                    <span class="sr-only">Menu</span>
                    <span class="fa fa-arrow-alt-down"></span>
                </button>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
                <ul class="nav navbar-nav navbar-right">
                    <?php
                        $currentUrl = Yii::$app->urlManager->parseRequest(Yii::$app->request);
                    ?>
                    <li <?php if($currentUrl[0] == "site/index") { ?>class="active" <?php } ?> >
                        <a href="<?php echo Yii::$app->getUrlManager()->createUrl('site/index'); ?>">صفحه اصلی</a>
                    </li>
                    <li <?php
                            if(explode('/', $currentUrl[0])[0] == "index") { ?>
                                class="active"
                            <?php } ?> >
                        <a href="<?php echo Yii::$app->getUrlManager()->createUrl('index/inplay'); ?>">پیش بینی فوتبال</a>
                    </li>
                    <li <?php if($currentUrl[0] == "site/help") { ?>class="active" <?php } ?>>
                        <a href="<?php echo Yii::$app->getUrlManager()->createUrl('site/help'); ?>">راهنما</a>
                    </li>
                    <li <?php if($currentUrl[0] == "site/support") { ?>class="active" <?php } ?>>
                        <a href="<?php echo Yii::$app->getUrlManager()->createUrl('site/support'); ?>">پشتیبانی</a>
                    </li>
<!--                    <li --><?php //if($currentUrl[0] == "site/rules") { ?><!--class="active" --><?php //} ?><!-->
<!--                        <a href="--><?php //echo Yii::$app->getUrlManager()->createUrl('site/rules'); ?><!--">قوانین و آموزش</a>-->
<!--                    </li>-->
                </ul>
            </div>

        </div>
    </nav>

    <div id="page-wrapper" class="gray-bg">
        <div class="contentpanel">
            <?= $content ?>
        </div>
    </div>


    <!-- Footer -->
    <footer class="page-footer">

        <!-- Footer Links -->
        <div class="container-fluid text-center">

            <div class="col-md-12">
                <div class="col-md-6 col-md-offset-3">

                    <div id="menu-outer">
                        <div class="table center-block">
                            <ul id="horizontal-list">
                                <li>
                                    <img src="/image/premier-league.png" class="league-icon" alt="premier-league" />
                                </li>
                                <li>
                                    <img src="/image/premier-league.png" class="league-icon" alt="premier-league" />
                                </li>
                                <li>
                                    <img src="/image/premier-league.png" class="league-icon" alt="premier-league" />
                                </li>
                                <li>
                                    <img src="/image/premier-league.png" class="league-icon" alt="premier-league" />
                                </li>
                                <li>
                                    <img src="/image/premier-league.png" class="league-icon" alt="premier-league" />
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <!-- Copyright -->
        <div class="footer-copyright text-center">
            تمام حقوق متعلق به سایت می باشد.
            © 1397 - 2018
        </div>
        <!-- Copyright -->

    </footer>
    <!-- Footer -->

</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
