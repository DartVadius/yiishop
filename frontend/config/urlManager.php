<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 16.08.17
 * Time: 21:41
 */

return [
    'class' => 'yii\web\UrlManager',
    'hostInfo' => $params['frontHost'],
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        '' => 'site/index',
        '<_a:about>' => 'site/<_a>',
        '<_a:login|signup>' => 'auth/<_a>',
        'contact' => 'contact/contact',

        'cabinet' => 'cabinet/index/index',
        'cabinet/<_c:[\w\-]+>' => 'cabinet/<_c>/index',
        'cabinet/<_c:[\w\-]+>/<id:\d+>' => 'cabinet/<_c>/view',
        'cabinet/<_c:[\w\-]+>/<_a:[\w\-]+>' => 'cabinet/<_c>/<_a>',
        'cabinet/<_c:[\w\-]+>/<id:\d+>/<_a:[\w-]+>' => 'cabinet/<_c>/<_a>',

        '<_c:[\w\-]+>' => '<_c>/index',
        '<_c:[\w\-]+>/<id:\d+>' => '<_c>/view',
        '<_c:[\w\-]+>/<_a:[\w\-]+>' => '<_c>/<_a>',
        '<_c:[\w\-]+>/<id:\d+>/<_a:[\w-]+>' => '<_c>/<_a>',
    ]
];