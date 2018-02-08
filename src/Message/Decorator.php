<?php

namespace Stampie\Extra\Message;

use Stampie\Message\AttachmentsAwareInterface;
use Stampie\Message\MetadataAwareInterface;
use Stampie\Message\TaggableInterface;
use Stampie\MessageInterface;

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
     * {@inheritdoc}
     */
    public function getFrom()
    {
        return $this->delegate->getFrom();
    }

    /**
     * {@inheritdoc}
     */
    public function getTo()
    {
        return $this->delegate->getTo();
    }

    /**
     * {@inheritdoc}
     */
    public function getCc()
    {
        return $this->delegate->getCc();
    }

    /**
     * {@inheritdoc}
     */
    public function getBcc()
    {
        return $this->delegate->getBcc();
    }

    /**
     * {@inheritdoc}
     */
    public function getSubject()
    {
        return $this->delegate->getSubject();
    }

    /**
     * {@inheritdoc}
     */
    public function getReplyTo()
    {
        return $this->delegate->getReplyTo();
    }

    /**
     * {@inheritdoc}
     */
    public function getHeaders()
    {
        return $this->delegate->getHeaders();
    }

    /**
     * {@inheritdoc}
     */
    public function getHtml()
    {
        return $this->delegate->getHtml();
    }

    /**
     * {@inheritdoc}
     */
    public function getText()
    {
        return $this->delegate->getText();
    }

    /**
     * {@inheritdoc}
     */
    public function getTag()
    {
        if ($this->delegate instanceof TaggableInterface) {
            return $this->delegate->getTag();
        }

        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getMetadata()
    {
        if ($this->delegate instanceof MetadataAwareInterface) {
            return $this->delegate->getMetadata();
        }

        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getAttachments()
    {
        if ($this->delegate instanceof AttachmentsAwareInterface) {
            return $this->delegate->getAttachments();
        }

        return [];
    }
}
