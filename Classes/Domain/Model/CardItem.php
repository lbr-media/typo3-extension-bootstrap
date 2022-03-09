<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Domain\Model;

use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Items for the content element bootstrap_cards.
 */
class CardItem extends AbstractEntity
{
    /**
     * @var string $header
     */
    protected $header = '';

    /**
     * @var string $title
     */
    protected $title = '';

    /**
     * @var FileReference $image
     */
    protected $image;

    /**
     * @var string $typolink
     */
    protected $typolink = '';

    /**
     * @var string $typolinkText
     */
    protected $typolinkText = '';

    /**
     * @var string $text
     */
    protected $text = '';

    /**
     * @var string $footer
     */
    protected $footer = '';

    /**
     * @return string
     */
    public function getHeader(): string
    {
        return $this->header;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return FileReference|null
     */
    public function getImage(): ?FileReference
    {
        return $this->image;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getTypolink(): string
    {
        return $this->typolink;
    }

    /**
     * @return string
     */
    public function getTypolinkText(): string
    {
        return $this->typolinkText;
    }

    /**
     * @return string
     */
    public function getFooter(): string
    {
        return $this->footer;
    }
}
