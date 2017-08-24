<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'bootstrap' => [
        'common\bootstrap\Setup',
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\MemCache',
            'useMemcached' => true,
        ],
    ],
];
