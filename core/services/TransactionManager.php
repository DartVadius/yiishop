<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 12.09.17
 * Time: 17:22
 */

namespace core\services;

use core\dispatchers\DeferredEventDispatcher;

class TransactionManager {
    private $dispatcher;

    public function __construct(DeferredEventDispatcher $dispatcher) {
        $this->dispatcher = $dispatcher;
    }

    public function wrap(callable $function) {
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $this->dispatcher->defer();
            $function();
            $transaction->commit();
            $this->dispatcher->release();
        } catch (\Exception $e) {
            $transaction->rollBack();
            $this->dispatcher->clean();
            throw $e;
        }
    }
}