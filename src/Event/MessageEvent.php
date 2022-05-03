<?php

namespace Stampie\Extra\Event;

use Stampie\MessageInterface;
use Symfony\Component\EventDispatcher\Event as LegacyEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface as ContractsEventDispatcherInterface;

// On Symfony 4.4, use the legacy event as the base class for BC reasons.
if (is_subclass_of(EventDispatcherInterface::class, ContractsEventDispatcherInterface::class)) {
    class_alias(Event::class, BaseEvent::class);
} else {
    class_alias(LegacyEvent::class, BaseEvent::class);
}

/**
 * @author Christophe Coevoet <stof@notk.org>
 *
 * @final
 */
class MessageEvent extends BaseEvent
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
