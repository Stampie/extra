<?php

namespace Stampie\Extra;

/**
 * Contains all events thrown in the StampieExtra library
 *
 * @author Christophe Coevoet <stof@notk.org>
 */
final class StampieEvents
{
    /**
     * The PRE_SEND event occurs before sending a message
     *
     * The event listener method receives a Stampie\Extra\Event\MessageEvent
     * instance.
     *
     * @var string
     */
    const PRE_SEND = 'stampie.pre_send';
}
