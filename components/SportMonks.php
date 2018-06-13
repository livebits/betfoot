<?php
/**
 * Created by PhpStorm.
 * User: AhmadKlfr
 * Date: 6/4/2018
 * Time: 11:40 PM
 */
namespace app\components;

use Yii;
use SportMonks\API\HTTPClient as SportMonksAPI;
use SportMonks\API\Utilities\Auth;

class SportMonks
{

    public static function init(){

        // Auth.
        $token = Yii::$app->params['betfoot_token'];

        // Default values. Can be initialized without arguments.
        $scheme = 'http';
        $hostname = 'sportmonks.com';
        $subDomain = 'soccer';
        $port = 80;

        $client = new SportMonksAPI();
        // or
//        $client = new SportMonksAPI($scheme, $hostname, $subDomain, $port);

        // Set auth.
        $client->setAuth(Auth::BASIC, [
            'token' => $token
        ]);

        return $client;
    }
}