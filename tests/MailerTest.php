<?php

namespace Stampie\Extra\Tests;

use PHPUnit\Framework\TestCase;
use Stampie\Extra\Mailer;
use Stampie\Extra\StampieEvents;

class MailerTest extends TestCase
{
    /**
     * @var Mailer
     */
    private $mailer;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $delegate;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $dispatcher;

    public function setUp()
    {
        $this->delegate = $this->getMockBuilder('Stampie\MailerInterface')->getMock();
        $this->dispatcher = $this->getMockBuilder('Symfony\Component\EventDispatcher\EventDispatcherInterface')->getMock();
        $this->mailer = new Mailer($this->delegate, $this->dispatcher);
    }

    public function testSend()
    {
        $message = $this->getMockBuilder('Stampie\MessageInterface')->getMock();

        $this->delegate->expects($this->once())
            ->method('send')
            ->with($this->equalTo($message))
            ->will($this->returnValue(true));

        $this->dispatcher->expects($this->once())
            ->method('dispatch')
            ->with($this->equalTo(StampieEvents::PRE_SEND), $this->isInstanceOf('Stampie\Extra\Event\MessageEvent'));

        $this->mailer->send($message);
    }
}
