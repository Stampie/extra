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

    public function testSetHttpClient()
    {
        $httpClient = $this->getMockBuilder('Http\Client\HttpClient')->getMock();

        $this->delegate->expects($this->once())
            ->method('setHttpClient')
            ->with($this->equalTo($httpClient));

        $this->mailer->setHttpClient($httpClient);
    }

    public function testSetServerToken()
    {
        $token = 'foo';

        $this->delegate->expects($this->once())
            ->method('setServerToken')
            ->with($this->equalTo($token));

        $this->mailer->setServerToken($token);
    }

    public function testGetServerToken()
    {
        $token = 'foo';

        $this->delegate->expects($this->once())
            ->method('getServerToken')
            ->will($this->returnValue($token));

        $this->assertSame($token, $this->mailer->getServerToken());
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

        $this->assertTrue($this->mailer->send($message));
    }
}
