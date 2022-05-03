<?php

namespace Stampie\Extra;

use Stampie\Extra\Event\MessageEvent;
use Stampie\MailerInterface;
use Stampie\MessageInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

/**
 * MailerInterface decorator dispatching events.
 *
 * @author Christophe Coevoet <stof@notk.org>
 *
 * @final
 */
class Mailer implements MailerInterface
{
    private $delegate;

    private $dispatcher;

    public function __construct(MailerInterface $delegate, EventDispatcherInterface $dispatcher)
    {
        $this->delegate = $delegate;
        $this->dispatcher = $dispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function send(MessageInterface $message)
    {
        $event = new MessageEvent($message);

        $this->dispatcher->dispatch($event, StampieEvents::PRE_SEND);

        $this->delegate->send($event->getMessage());
    }
}
