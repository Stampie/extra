<?php

namespace Stampie\Extra\Tests;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Stampie\Extra\Event\MessageEvent;
use Stampie\Extra\Mailer;
use Stampie\Extra\StampieEvents;
use Stampie\MailerInterface;
use Stampie\MessageInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

class MailerTest extends TestCase
{
    /**
     * @var Mailer
     */
    private $mailer;

    /**
     * @var MockObject&MailerInterface
     */
    private $delegate;

    /**
     * @var EventDispatcher
     */
    private $dispatcher;

    protected function setUp(): void
    {
        $this->delegate = $this->getMockBuilder(MailerInterface::class)->getMock();
        $this->dispatcher = new EventDispatcher();
        $this->mailer = new Mailer($this->delegate, $this->dispatcher);
    }

    public function testTriggersAnEventWithTheMessage()
    {
        $message = $this->getMockBuilder(MessageInterface::class)->getMock();

        $called = false;
        $listener = function (MessageEvent $event) use ($message, &$called) {
            $called = true;
            $this->assertSame($message, $event->getMessage());
        };
        $this->dispatcher->addListener(StampieEvents::PRE_SEND, $listener);

        $this->delegate->expects($this->once())
            ->method('send')
            ->with($this->identicalTo($message));

        $this->mailer->send($message);

        $this->assertTrue($called, 'The listener should be called.');
    }

    public function testAllowsReplacingTheMessageInListeners()
    {
        $message = $this->getMockBuilder(MessageInterface::class)->getMock();
        $newMessage = $this->getMockBuilder(MessageInterface::class)->getMock();

        $this->dispatcher->addListener(StampieEvents::PRE_SEND, function (MessageEvent $event) use ($newMessage) {
            $event->setMessage($newMessage);
        });

        $this->delegate->expects($this->once())
            ->method('send')
            ->with($this->identicalTo($newMessage));

        $this->mailer->send($message);
    }
}
