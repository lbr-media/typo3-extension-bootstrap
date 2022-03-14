<?php

declare(strict_types=1);

/*
 * @package LBRmedia Bootstrap Template - Provides Twitter Bootstrap 5 and some content elements.
 * @version 1.0.17
 * @author Marcel Briefs <mb@lbrmedia.de>
 * @copyright 2022 LBRmedia
 * @link https://github.com/lbr-media/typo3-extension-bootstrap
 * @license GPL-2.0-or-later
 */

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
     * @var string $iconset
     */
    protected $iconset = ';;;;';

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
    public function getIconset(): string
    {
        return $this->iconset;
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
