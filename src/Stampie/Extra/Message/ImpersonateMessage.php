<?php

namespace Stampie\Extra\Message;

use Stampie\MessageInterface;
use Stampie\Util\IdentityUtils;

/**
 * MessageInterface decorator changing the recipient.
 *
 * @author Christophe Coevoet <stof@notk.org>
 */
class ImpersonateMessage extends Decorator
{
    private $recipient;

    public function __construct(MessageInterface $delegate, $recipient)
    {
        parent::__construct($delegate);

        $this->recipient = $recipient;
    }

    /**
     * {@inheritDoc}
     */
    public function getTo()
    {
        return $this->recipient;
    }

    /**
     * {@inheritDoc}
     */
    public function getHeaders()
    {
        return array_merge(
            $this->delegate->getHeaders(),
            array('X-Stampie-To' => IdentityUtils::buildIdentityString($this->delegate->getTo()))
        );
    }
}
