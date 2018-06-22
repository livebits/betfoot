<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\Menu;
use app\assets\AppAsset;
use webvimark\modules\UserManagement\components\GhostMenu;
use webvimark\modules\UserManagement\components\GhostNav;
use webvimark\modules\UserManagement\UserManagementModule;

$this->title = 'راهنما';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">

    <div class="container center-content">

        <div class="col-md-12">

            <div class="box ajax">
                <div class="header">

                    <div class="header-container">
                        <div id="sport-header" class="sports-header">
                            <h1 class="sports-info-header">
                                <div>
                                <span class="match_list_date">
                                    راهنما
                                </span>
                            </h1>
                        </div>
                    </div>
                </div>
                <div class="body" style="font-size: 18px;">

                    <table class="table match_list table-responsive">

                        <tr class="match_group_header">
                            <td style="text-align: right;">درباره ما بیشتر بدانید</td>
                        </tr>
                        <tr class="match_group_item">
                            <td style="text-align: right;">
                                سایت ما یک سایت شرط بندی فوتبال و کازینوی آنلاین است که سعی کرده است امکان شرط بندی برای کاربران فارسی زبان را فراهم کند. طراحی سایت بسیار زیبا و گویا است و هر کاربر با کمترین آشنایی با مسابقات ورزشی میتواند در این سایت شروع به شرط بندی کند و از هیجان آن لذت ببرد.
                                برای شروع شرط بندی در این سایت ، چهار مرحله زیر را انجام دهید و به راحتی و در چند دقیقه شروع به شرط بندی کنید.
                            </td>
                        </tr>

                        <tr class="match_group_header">
                            <td style="text-align: right;">۱ در این سایت ثبت نام کنید.</td>
                        </tr>
                        <tr class="match_group_item">
                            <td style="text-align: right;">
                                برای شروع شرط بندی باید ابتدا یک حساب کاربری در این سایت ایجاد کنید. روند ایجاد حساب کاربری بسیار آسان و امن است و شما میتوانید هر زمان که مایل بودید با پر کردن فرم ثبت نام حساب کاربری خود را در این سایت بسازید. بروی لینک نام نویسی در بالای صفحه گوشه سمت راست کلید کنید. روند نام نویسی را دنبال کنید، حساب کاربری شما فعال می شود.
                            </td>
                        </tr>

                        <tr class="match_group_header">
                            <td style="text-align: right;">۲ موجودی حساب خود را افزایش دهید.</td>
                        </tr>
                        <tr class="match_group_item">
                            <td style="text-align: right;">
                                به محض اینکه حساب کاربری شما فعال شد، برای شروع شرط بندی باید موجودی حساب خود را در سایت افزایش دهید. پرداخت از طریق کارت بانکی و درگاه پرداخت بانکی، حساب شما باید در این سایت در کمتر از چند دقیقه شارژ شود اگر این اتفاق صورت نگرفت، در این شرایط از طریق بخش پشتیبانی و با ارسال کد سفارش، خرید خود را پیگیری کنید.
                            </td>
                        </tr>

                        <tr class="match_group_header">
                            <td style="text-align: right;">۳ شروع به شرط بندی کنید</td>
                        </tr>
                        <tr class="match_group_item">
                            <td style="text-align: right;">
                                برای شرط بندی میتوانید در مسابقات پیش بینی زنده و یا پیش از بازی کارشناسی فوتبال شرکت کنید یا به صورت تکی و میکس و زنده روی مسابقات فوتبال شرط بندی کنید. اگر علاقه ای به شرط بندی روی فوتبال ندارید میتوانید وارد کازینوی آنلاین این سایت شوید و روی بازی های کازینویی شرط بندی کنید.
                            </td>
                        </tr>

                        <tr class="match_group_header">
                            <td style="text-align: right;">۴جوایز خود را برداشت کنید.</td>
                        </tr>
                        <tr class="match_group_item">
                            <td style="text-align: right;">
                                در هر کدام از پیش بینی ها که برنده شوید مبلغ برد شما بلافاصله به موجودی حساب شما واریز می شود. شما میتوانید موجودی حساب خود را در پیش بینی های بعدی استفاده کنید یا آن را برداشت کنید. برای برداشت از حساب می توانید به منوی درخواست برداشت واقع در منوی حساب کاربری بالای سایت مراجعه کرده و با پرکردن اطلاعات حساب بانکی و مبلغ درخواستی و با کلیک بر گزینه درخواست، درخواست خود را برای بخش امور مالی سایت ارسال نمایید. در نظر داشته باشید که مبلغ درخواستی شما در این سایت حداکثر تا ۲۴ ساعت به حساب بانکی شما واریز خواهد شد.
                            </td>
                        </tr>
                    </table>
                </div>
            </div>


        </div>
    </div>

</div>
