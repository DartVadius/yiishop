<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 27.08.17
 * Time: 11:49
 */

namespace frontend\controllers\cabinet;


use yii\filters\AccessControl;
use yii\web\Controller;

class IndexController extends Controller {
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
//                    'actions' => ['cabinet/index'],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }

    public function actionIndex() {
        return $this->render('index');
    }
}