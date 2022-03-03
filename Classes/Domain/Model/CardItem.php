<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Domain\Model;

use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * items for content element bootstrap_cards
 */
class CardItem extends AbstractEntity
{
    /**
     * @var string
     */
    protected $header = '';

    /**
     * @var string
     */
    protected $title = '';

    /**
     * @var FileReference
     */
    protected $image;

    /**
     * @var string
     */
    protected $typolink = '';

    /**
     * @var string
     */
    protected $typolinkText = '';

    /**
     * @var string
     */
    protected $text = '';

    /**
     * @var string
     */
    protected $footer = '';

    public function getHeader(): string
    {
        return $this->header;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getImage(): ?FileReference
    {
        return $this->image;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getTypolink(): string
    {
        return $this->typolink;
    }

    public function getTypolinkText(): string
    {
        return $this->typolinkText;
    }

    public function getFooter(): string
    {
        return $this->footer;
    }
}
