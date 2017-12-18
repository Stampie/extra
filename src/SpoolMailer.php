<?php

namespace Stampie\Extra;

use Stampie\MailerInterface;
use Stampie\MessageInterface;

/**
 * MailerInterface decorator spooling messages in memory
 *
 * @author Christophe Coevoet <stof@notk.org>
 */
class SpoolMailer implements MailerInterface
{
    private $delegate;

    private $messages = array();

    public function __construct(MailerInterface $delegate)
    {
        $this->delegate = $delegate;
    }

    /**
     * {@inheritDoc}
     */
    public function send(MessageInterface $message)
    {
        $this->messages[] = $message;
    }

    /**
     * Flushes the spool.
     */
    public function flushSpool()
    {
        while ($message = array_pop($this->messages)) {
            $this->delegate->send($message);
        }
    }
}
