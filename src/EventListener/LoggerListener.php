<?php

namespace Stampie\Extra\EventListener;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Stampie\Extra\Event\MessageEvent;
use Stampie\Extra\StampieEvents;
use Stampie\Util\IdentityUtils;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Listener responsible to log the sent emails.
 */
class LoggerListener implements EventSubscriberInterface
{
    private $logger;

    private $logLevel;

    public function __construct(LoggerInterface $logger = null, $logLevel = LogLevel::DEBUG)
    {
        $this->logger = $logger;
        $this->logLevel = $logLevel;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            StampieEvents::PRE_SEND => 'preSend',
        ];
    }

    public function preSend(MessageEvent $event)
    {
        if (null === $this->logger) {
            return;
        }

        $message = $event->getMessage();

        $this->logger->log(
            $this->logLevel,
            sprintf('Sending an email from "%s" to "%s"', IdentityUtils::buildIdentityString($message->getFrom()), IdentityUtils::buildIdentityString($message->getTo())),
            ['subject' => $message->getSubject(), 'headers' => $message->getHeaders()]
        );
    }
}
