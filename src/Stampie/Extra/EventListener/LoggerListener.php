<?php

namespace Stampie\Extra\EventListener;

use Stampie\Extra\StampieEvents;
use Stampie\Extra\Event\MessageEvent;
use Stampie\Extra\Util\IdentityUtils;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Log\LoggerInterface;

/**
 * Listener responsible to log the sent emails.
 */
class LoggerListener implements EventSubscriberInterface
{
    private $logger;

    public function __construct(LoggerInterface $logger = null)
    {
        $this->logger = $logger;
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            StampieEvents::PRE_SEND => 'preSend',
        );
    }

    public function preSend(MessageEvent $event)
    {
        if (null === $this->logger) {
            return;
        }

        $message = $event->getMessage();

        $this->logger->debug(
            sprintf('Sending an email from "%s" to "%s"', IdentityUtils::formatIdentities($message->getFrom()), IdentityUtils::formatIdentities($message->getTo())),
            array('subject' => $message->getSubject(), 'headers' => $message->getHeaders())
        );
    }
}
