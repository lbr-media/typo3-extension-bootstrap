<?php

declare(strict_types=1);

/*
 * @package LBRmedia Bootstrap Template - Provides Twitter Bootstrap 5 and some content elements.
 * @version 12.0.0
 * @author Marcel Briefs <mb@lbrmedia.de>
 * @copyright 2022 LBRmedia
 * @link https://github.com/lbr-media/typo3-extension-bootstrap
 * @license GPL-2.0-or-later
 */

namespace LBRmedia\Bootstrap\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Items for the content element bootstrap_tabulator.
 */
class TabulatorItem extends AbstractEntity
{
    /**
     * @var string $title
     */
    protected $title = '';

    /**
     * @var bool $active
     */
    protected $active = false;

    /**
     * @var ObjectStorage<ContentElement> $contentElements
     */
    protected $contentElements;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return bool
     */
    public function getActive(): bool
    {
        return $this->active;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->getActive();
    }

    /**
     * @param bool $active
     */
    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    /**
     * @return ObjectStorage<ContentElement>
     */
    public function getContentElements(): ObjectStorage
    {
        return $this->contentElements;
    }
}
