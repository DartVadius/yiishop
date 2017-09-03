<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 02.09.17
 * Time: 20:18
 */

namespace core\entities\behaviors;


use yii\base\Behavior;
use yii\base\Event;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use core\entities\meta\Meta;

class MetaBehavior extends Behavior {

    public $attribute = 'meta';
    public $jsonDbField = 'meta_json';

    public function events() {
        return [
            ActiveRecord::EVENT_AFTER_FIND => 'onAfterFind',
            ActiveRecord::EVENT_BEFORE_INSERT => 'onBeforeSave',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'onBeforeSave',
        ];
    }

    public function onAfterFind(Event $event) {
        $item = $event->sender;

        $meta = Json::decode($item->getAttribute($this->jsonDbField));
        $item->{$this->attribute} = new Meta(
            ArrayHelper::getValue($meta, 'title'),
            ArrayHelper::getValue($meta,'description'),
            ArrayHelper::getValue($meta, 'keywords')
        );
    }

    public function onBeforeSave(Event $event) {
        $item = $event->sender;

        $item->setAttribute($this->jsonDbField, Json::encode([
            'title' => $item->{$this->attribute}->title,
            'description' => $item->{$this->attribute}->description,
            'keywords' => $item->{$this->attribute}->keywords,
        ]));
    }
}