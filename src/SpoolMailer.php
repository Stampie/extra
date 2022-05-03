<?php

namespace Stampie\Extra;

use Stampie\MailerInterface;
use Stampie\MessageInterface;

/**
 * MailerInterface decorator spooling messages in memory.
 *
 * @author Christophe Coevoet <stof@notk.org>
 *
 * @final
 */
class SpoolMailer implements MailerInterface
{
    private $delegate;

    private $messages = [];

    public function __construct(MailerInterface $delegate)
    {
        $this->delegate = $delegate;
    }

    /**
     * {@inheritdoc}
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
