<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\Menu;
use app\assets\AppAsset;
use webvimark\modules\UserManagement\components\GhostMenu;
use webvimark\modules\UserManagement\components\GhostNav;
use webvimark\modules\UserManagement\UserManagementModule;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
        GhostNav::begin([
            //'brandLabel' => 'My Company',
            //'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],
        ]);

        echo GhostMenu::widget([
            'encodeLabels'=>false,
            'activateParents'=>true,

            'items' => [
                [
                    'label' => 'Backend routes',
                    'items'=>UserManagementModule::menuItems()
                ],
                [
                    'label' => 'Frontend routes',
                    'items'=>[
                        ['label'=>'Login', 'url'=>['/user-management/auth/login']],
                        ['label'=>'Logout', 'url'=>['/user-management/auth/logout']],
                        ['label'=>'Registration', 'url'=>['/user-management/auth/registration']],
                        ['label'=>'Change own password', 'url'=>['/user-management/auth/change-own-password']],
                        ['label'=>'Password recovery', 'url'=>['/user-management/auth/password-recovery']],
                        ['label'=>'E-mail confirmation', 'url'=>['/user-management/auth/confirm-email']],
                    ],
                ],
            ],

        ]);

        GhostNav::end();

        ?>
    </p>

    <code><?= __FILE__ ?></code>
</div>
