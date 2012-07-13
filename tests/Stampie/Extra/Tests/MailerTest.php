<?php

namespace Stampie\Extra\Tests;

use Stampie\Extra\Mailer;

class MailerTest extends \PHPUnit_Framework_TestCase
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
        $this->delegate = $this->getMock('Stampie\MailerInterface');
        $this->dispatcher = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
        $this->mailer = new Mailer($this->delegate, $this->dispatcher);
    }

    public function testSetAdapter()
    {
        $adapter = $this->getMock('Stampie\Adapter\AdapterInterface');

        $this->delegate->expects($this->once())
            ->method('setAdapter')
            ->with($this->equalTo($adapter));

        $this->mailer->setAdapter($adapter);
    }

    public function testGetAdapter()
    {
        $adapter = $this->getMock('Stampie\Adapter\AdapterInterface');

        $this->delegate->expects($this->once())
            ->method('getAdapter')
            ->will($this->returnValue($adapter));

        $this->assertSame($adapter, $this->mailer->getAdapter());
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
        $message = $this->getMock('Stampie\MessageInterface');

        $this->delegate->expects($this->once())
            ->method('send')
            ->with($this->equalTo($message))
            ->will($this->returnValue(true));

        $this->assertTrue($this->mailer->send($message));
    }
}
