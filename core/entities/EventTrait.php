<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 26.09.17
 * Time: 21:00
 */

namespace core\entities;


trait EventTrait {
    private $events = [];

    protected function recordEvent($event): void {
        $this->events[] = $event;
    }

    public function releaseEvents(): array {
        $events = $this->events;
        $this->events = [];
        return $events;
    }
}