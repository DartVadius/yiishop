<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 16.08.17
 * Time: 21:41
 */

return [
    'class' => 'yii\web\UrlManager',
    'hostInfo' => $params['backHost'],
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        '' => 'site/index',
        '<_a:about|contact|login|signup>' => 'site/<_a>',
        '<_c:[\w\-]+>' => '<_c>/index',
        '<_c:[\w\-]+>/<id:\d+>' => '<_c>/view',
        '<_c:[\w\-]+>/<_a:[\w\-]+>' => '<_c>/<_a>',
        '<_c:[\w\-]+>/<id:\d+>/<_a:[\w-]+>' => '<_c>/<_a>',
    ],
];