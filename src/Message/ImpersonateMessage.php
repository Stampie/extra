<?php

namespace Stampie\Extra\Message;

use Stampie\MessageInterface;
use Stampie\Util\IdentityUtils;

/**
 * MessageInterface decorator changing the recipient.
 *
 * @author Christophe Coevoet <stof@notk.org>
 *
 * @internal
 * @final
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
    }

    public function getBcc()
    {
    }

    public function getHeaders()
    {
        return array_merge(
            $this->delegate->getHeaders(),
            [
                'X-Stampie-To'  => IdentityUtils::buildIdentityString($this->delegate->getTo()),
                'X-Stampie-Cc'  => IdentityUtils::buildIdentityString($this->delegate->getCc()),
                'X-Stampie-Bcc' => IdentityUtils::buildIdentityString($this->delegate->getBcc()),
            ]
        );
    }
}
