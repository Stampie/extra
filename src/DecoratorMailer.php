<?php

namespace Stampie\Extra;

use Http\Client\HttpClient;
use Stampie\MailerInterface;
use Stampie\MessageInterface;

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

    /**
     * {@inheritDoc}
     */
    public function setHttpClient(HttpClient $adapter)
    {
        $this->delegate->setHttpClient($adapter);
    }
}
