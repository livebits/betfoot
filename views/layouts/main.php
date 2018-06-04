<?php

/* @var $content string */

use app\assets\AppAsset;

use yii\helpers\Html;


AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en"
      class="js flexbox flexboxlegacy canvas canvastext webgl no-touch geolocation postmessage websqldatabase indexeddb hashchange history draganddrop websockets rgba hsla multiplebgs backgroundsize borderimage borderradius boxshadow textshadow opacity cssanimations csscolumns cssgradients cssreflections csstransforms csstransforms3d csstransitions fontface generatedcontent video audio localstorage sessionstorage webworkers applicationcache svg inlinesvg smil svgclippaths rtl translated-rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?= Yii::$app->homeUrl ?>/images/" type="image/png">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link href="/web/css/bootstrap.min.css" rel="stylesheet">
    <link href="/web/css/font-awesome.css" rel="stylesheet">
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
                <a class="navbar-brand" href="#">Betfoot</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <form class="navbar-form navbar-right">
                    <div class="form-group">
                        <input type="text" name="username" class="form-control" placeholder="نام کاربری">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="رمز عبور">
                    </div>
                    <button type="submit" class="btn btn-success">ورود</button>

                    <a href="">
                        <button type="button" class="btn yellow-btn">ثبت نام!</button>
                    </a>
                </form>
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
                    <li class="active">
                        <a href="#">Link</a>
                    </li>
                    <li>
                        <a href="#">Link</a>
                    </li>

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
    <footer class="page-footer" style="background: white;">

        <!-- Footer Links -->
        <div class="container-fluid text-center">

            <div class="col-md-12">
                <div class="col-md-6 col-md-offset-3">

                    <div id="menu-outer">
                        <div class="table center-block">
                            <ul id="horizontal-list">
                                <li>
                                    <img src="image/premier-league.png" class="league-icon" alt="premier-league" />
                                </li>
                                <li>
                                    <img src="image/premier-league.png" class="league-icon" alt="premier-league" />
                                </li>
                                <li>
                                    <img src="image/premier-league.png" class="league-icon" alt="premier-league" />
                                </li>
                                <li>
                                    <img src="image/premier-league.png" class="league-icon" alt="premier-league" />
                                </li>
                                <li>
                                    <img src="image/premier-league.png" class="league-icon" alt="premier-league" />
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <!-- Copyright -->
        <div class="footer-copyright text-center">
            © 2018 حق کپی رایت برای سایت محفوظ می باشد.
        </div>
        <!-- Copyright -->

    </footer>
    <!-- Footer -->

</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
