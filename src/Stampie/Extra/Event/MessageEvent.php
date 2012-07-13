<?php

namespace Stampie\Extra\Event;

use Stampie\MessageInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * @author Christophe Coevoet <stof@notk.org>
 */
class MessageEvent extends Event
{
    private $message;

    public function __construct(MessageInterface $message)
    {
        $this->message = $message;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage(MessageInterface $message)
    {
        $this->message = $message;
    }
}
