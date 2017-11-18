<?php

namespace Stampie\Extra;

use Stampie\Extra\Event\MessageEvent;
use Stampie\MailerInterface;
use Stampie\MessageInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * MailerInterface decorator dispatching events
 *
 * @author Christophe Coevoet <stof@notk.org>
 */
class Mailer extends DecoratorMailer
{
    private $dispatcher;

    public function __construct(MailerInterface $delegate, EventDispatcherInterface $dispatcher)
    {
        parent::__construct($delegate);

        $this->dispatcher = $dispatcher;
    }

    /**
     * {@inheritDoc}
     */
    public function send(MessageInterface $message)
    {
        $event = new MessageEvent($message);
        $this->dispatcher->dispatch(StampieEvents::PRE_SEND, $event);

        return parent::send($event->getMessage());
    }
}
