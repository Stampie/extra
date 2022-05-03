<?php

namespace Stampie\Extra\EventListener;

use Stampie\Extra\Event\MessageEvent;
use Stampie\Extra\Message\ImpersonateMessage;
use Stampie\Extra\StampieEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Listener responsible to update the recipient of the message.
 *
 * @final
 */
class ImpersonateListener implements EventSubscriberInterface
{
    private $recipient;

    public function __construct($recipient)
    {
        $this->recipient = $recipient;
    }

    /**
     * {@inheritdoc}
     *
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [StampieEvents::PRE_SEND => 'preSend'];
    }

    public function preSend(MessageEvent $event)
    {
        $message = new ImpersonateMessage($event->getMessage(), $this->recipient);

        $event->setMessage($message);
    }
}
