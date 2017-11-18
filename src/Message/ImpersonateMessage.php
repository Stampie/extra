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

    public function getTo()
    {
        return $this->recipient;
    }

    public function getCc()
    {
        return null;
    }

    public function getBcc()
    {
        return null;
    }

    public function getHeaders()
    {
        return array_merge(
            $this->delegate->getHeaders(),
            array(
                'X-Stampie-To' => IdentityUtils::buildIdentityString($this->delegate->getTo()),
                'X-Stampie-Cc' => IdentityUtils::buildIdentityString($this->delegate->getCc()),
                'X-Stampie-Bcc' => IdentityUtils::buildIdentityString($this->delegate->getBcc()),
            )
        );
    }
}
