<?php

namespace Stampie\Extra\Tests\EventListener;

use PHPUnit\Framework\TestCase;
use Psr\Log\AbstractLogger;
use Psr\Log\LogLevel;
use Stampie\Extra\Event\MessageEvent;
use Stampie\Extra\EventListener\LoggerListener;
use Stampie\MessageInterface;

class LoggerListenerTest extends TestCase
{
    public function testCanBeCalledWithoutLogger()
    {
        $originalMessage = $this->createMock(MessageInterface::class);
        $originalMessage->method('getTo')->willReturn('to@example.com');
        $originalMessage->method('getFrom')->willReturn('from@example.com');
        $originalMessage->method('getSubject')->willReturn('Original subject');
        $originalMessage->method('getHeaders')->willReturn([]);

        $event = new MessageEvent($originalMessage);

        $listener = new LoggerListener(null);
        $listener->preSend($event);

        $this->assertSame($originalMessage, $event->getMessage());
    }

    public function testLogsAtDebugLevel()
    {
        $originalMessage = $this->createMock(MessageInterface::class);
        $originalMessage->method('getTo')->willReturn('to@example.com');
        $originalMessage->method('getFrom')->willReturn('from@example.com');
        $originalMessage->method('getSubject')->willReturn('Original subject');
        $originalMessage->method('getHeaders')->willReturn([]);

        $event = new MessageEvent($originalMessage);

        $logger = $this->getMockForAbstractClass(AbstractLogger::class);
        $logger->expects($this->once())
            ->method('log')
            ->with(LogLevel::DEBUG, 'Sending an email from "from@example.com" to "to@example.com"');

        $listener = new LoggerListener($logger);
        $listener->preSend($event);

        $this->assertSame($originalMessage, $event->getMessage());
    }

    public function testCanLogAtADifferentLevel()
    {
        $originalMessage = $this->createMock(MessageInterface::class);
        $originalMessage->method('getTo')->willReturn('to@example.com');
        $originalMessage->method('getFrom')->willReturn('from@example.com');
        $originalMessage->method('getSubject')->willReturn('Original subject');
        $originalMessage->method('getHeaders')->willReturn([]);

        $event = new MessageEvent($originalMessage);

        $logger = $this->getMockForAbstractClass(AbstractLogger::class);
        $logger->expects($this->once())
            ->method('log')
            ->with(LogLevel::INFO, 'Sending an email from "from@example.com" to "to@example.com"');

        $listener = new LoggerListener($logger, LogLevel::INFO);
        $listener->preSend($event);

        $this->assertSame($originalMessage, $event->getMessage());
    }
}
