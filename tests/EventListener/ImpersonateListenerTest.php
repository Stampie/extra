<?php

namespace Stampie\Extra\Tests\EventListener;

use PHPUnit\Framework\TestCase;
use Stampie\Extra\Event\MessageEvent;
use Stampie\Extra\EventListener\ImpersonateListener;
use Stampie\MessageInterface;

class ImpersonateListenerTest extends TestCase
{
    public function testImpersonation()
    {
        $originalMessage = $this->createMock(MessageInterface::class);
        $originalMessage->method('getTo')->willReturn('to@example.com');
        $originalMessage->method('getCc')->willReturn('cc@example.com');
        $originalMessage->method('getBcc')->willReturn('bcc@example.com');
        $originalMessage->method('getFrom')->willReturn('from@example.com');
        $originalMessage->method('getSubject')->willReturn('Original subject');
        $originalMessage->method('getText')->willReturn('Original text');
        $originalMessage->method('getHtml')->willReturn('Original html');
        $originalMessage->method('getHeaders')->willReturn(['X-Foo' => 'bar']);

        $event = new MessageEvent($originalMessage);

        $listener = new ImpersonateListener('impersonated@example.com');
        $listener->preSend($event);

        $finalMessage = $event->getMessage();

        $this->assertEquals('impersonated@example.com', $finalMessage->getTo());
        $this->assertNull($finalMessage->getCc());
        $this->assertNull($finalMessage->getBcc());
        $this->assertEquals('Original subject', $finalMessage->getSubject());
        $this->assertEquals('Original text', $finalMessage->getText());
        $this->assertEquals('Original html', $finalMessage->getHtml());

        $expectedHeaders = [
            'X-Foo'         => 'bar',
            'X-Stampie-To'  => 'to@example.com',
            'X-Stampie-Cc'  => 'cc@example.com',
            'X-Stampie-Bcc' => 'bcc@example.com',
        ];

        $this->assertEquals($expectedHeaders, $finalMessage->getHeaders());
    }
}
