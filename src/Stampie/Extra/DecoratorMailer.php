<?php

namespace Stampie\Extra;

use Stampie\MailerInterface;
use Stampie\MessageInterface;
use Stampie\Adapter\AdapterInterface;

/**
 * base MailerInterface decorator without extra logic.
 *
 * @author Christophe Coevoet <stof@notk.org>
 */
class DecoratorMailer implements MailerInterface
{
    private $delegate;

    public function __construct(MailerInterface $delegate)
    {
        $this->delegate = $delegate;
    }

    /**
     * {@inheritDoc}
     */
    public function send(MessageInterface $message)
    {
        return $this->delegate->send($message);
    }

    /**
     * {@inheritDoc}
     */
    public function setAdapter(AdapterInterface $adapter)
    {
        $this->delegate->setAdapter($adapter);
    }

    /**
     * {@inheritDoc}
     */
    public function getAdapter()
    {
        return $this->delegate->getAdapter();
    }

    /**
     * {@inheritDoc}
     */
    public function setServerToken($serverToken)
    {
        $this->delegate->setServerToken($serverToken);
    }

    /**
     * {@inheritDoc}
     */
    public function getServerToken()
    {
        return $this->delegate->getServerToken();
    }
}
