<?php
return yii\helpers\ArrayHelper::merge(
    require(Yii::getAlias('@common/config') . '/main.php'),
    require(Yii::getAlias('@common/config') . '/main-local.php'),
    require(__DIR__ . '/test.php'),
    [
        'components' => [
            'db' => [
                'dsn' => 'mysql:host=localhost;dbname=yiishop_test',
            ]
        ],
        'params' => require(__DIR__ . '/test-params.php'),
    ]

);
