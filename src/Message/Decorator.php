<?php

namespace Stampie\Extra\Message;

use Stampie\MessageInterface;
use Stampie\Message\AttachmentsAwareInterface;
use Stampie\Message\MetadataAwareInterface;
use Stampie\Message\TaggableInterface;

/**
 * MessageInterface decorator proxying all calls without extra logic.
 *
 * This class is meant to be used as a base class by other decorators.
 *
 * @author Christophe Coevoet <stof@notk.org>
 */
class Decorator implements MessageInterface, TaggableInterface, MetadataAwareInterface, AttachmentsAwareInterface
{
    protected $delegate;

    public function __construct(MessageInterface $delegate)
    {
        $this->delegate = $delegate;
    }

    /**
     * {@inheritDoc}
     */
    public function getFrom()
    {
        return $this->delegate->getFrom();
    }

    /**
     * {@inheritDoc}
     */
    public function getTo()
    {
        return $this->delegate->getTo();
    }

    /**
     * {@inheritDoc}
     */
    public function getCc()
    {
        return $this->delegate->getCc();
    }

    /**
     * {@inheritDoc}
     */
    public function getBcc()
    {
        return $this->delegate->getBcc();
    }

    /**
     * {@inheritDoc}
     */
    public function getSubject()
    {
        return $this->delegate->getSubject();
    }

    /**
     * {@inheritDoc}
     */
    public function getReplyTo()
    {
        return $this->delegate->getReplyTo();
    }

    /**
     * {@inheritDoc}
     */
    public function getHeaders()
    {
        return $this->delegate->getHeaders();
    }

    /**
     * {@inheritDoc}
     */
    public function getHtml()
    {
        return $this->delegate->getHtml();
    }

    /**
     * {@inheritDoc}
     */
    public function getText()
    {
        return $this->delegate->getText();
    }

    /**
     * {@inheritDoc}
     */
    public function getTag()
    {
        if ($this->delegate instanceof TaggableInterface) {
            return $this->delegate->getTag();
        }

        return array();
    }

    /**
     * {@inheritDoc}
     */
    public function getMetadata()
    {
        if ($this->delegate instanceof MetadataAwareInterface) {
            return $this->delegate->getMetadata();
        }

        return array();
    }

    /**
     * {@inheritDoc}
     */
    public function getAttachments()
    {
        if ($this->delegate instanceof AttachmentsAwareInterface) {
            return $this->delegate->getAttachments();
        }

        return array();
    }
}
