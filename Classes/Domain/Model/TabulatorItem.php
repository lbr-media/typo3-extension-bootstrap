<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Items for the content element bootstrap_tabulator.
 */
class TabulatorItem extends AbstractEntity
{
    /**
     * @var string
     */
    protected $title = '';

    /**
     * @var bool
     */
    protected $active = false;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\LBRmedia\Bootstrap\Domain\Model\ContentElement>
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
     * 
     * @return void
     */
    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\LBRmedia\Bootstrap\Domain\Model\ContentElement>
     */
    public function getContentElements(): \TYPO3\CMS\Extbase\Persistence\ObjectStorage
    {
        return $this->contentElements;
    }
}
