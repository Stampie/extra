<?php

namespace Stampie\Extra;

use Stampie\Extra\Event\MessageEvent;
use Stampie\MailerInterface;
use Stampie\MessageInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface as ContractsEventDispatcherInterface;

/**
 * MailerInterface decorator dispatching events.
 *
 * @author Christophe Coevoet <stof@notk.org>
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

        if ($this->dispatcher instanceof ContractsEventDispatcherInterface) {
            $this->dispatcher->dispatch($event, StampieEvents::PRE_SEND);
        } else {
            $this->dispatcher->dispatch(StampieEvents::PRE_SEND, $event);
        }

        $this->delegate->send($event->getMessage());
    }
}
