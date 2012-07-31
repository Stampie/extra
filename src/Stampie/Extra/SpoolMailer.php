<?php

namespace Stampie\Extra;

use Stampie\MessageInterface;

/**
 * MailerInterface decorator spooling messages in memory
 *
 * @author Christophe Coevoet <stof@notk.org>
 */
class SpoolMailer extends DecoratorMailer
{
    private $messages = array();

    /**
     * {@inheritDoc}
     */
    public function send(MessageInterface $message)
    {
        $this->messages[] = $message;

        return true;
    }

    /**
     * Flushes the spool.
     */
    public function flushSpool()
    {
        while ($message = array_pop($this->messages)) {
            parent::send($message);
        }
    }
}
