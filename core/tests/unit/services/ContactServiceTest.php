<?php
namespace core\tests\unit\services;

use core\services\contact\ContactService;
use Yii;
use core\forms\auth\ContactForm;

class ContactServiceTest extends \Codeception\Test\Unit
{
    public function testSendEmail()
    {
        $model = new ContactForm();
        $service = Yii::$container->get(ContactService::class);
        $model->attributes = [
            'name' => 'Tester',
            'email' => 'tester@example.com',
            'subject' => 'very important letter subject',
            'body' => 'body of current message',
        ];

        $this->assertTrue($service->send($model));
//        // using Yii2 module actions to check email was sent

        $this->tester->seeEmailIsSent();

        $emailMessage = $this->tester->grabLastSentEmail();
        expect('valid email is sent', $emailMessage)->isInstanceOf('yii\mail\MessageInterface');
        expect($emailMessage->getTo())->hasKey('admin@example.com');
        expect($emailMessage->getFrom())->hasKey('tester@example.com');
        expect($emailMessage->getSubject())->equals('very important letter subject');
        expect($emailMessage->toString())->contains('body of current message');
    }
}
