<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Items for the tabulator content element
 */
class TabulatorItem extends AbstractEntity
{
    /**
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $title = '';

    /**
     * @var bool
     */
    protected $active = false;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\LBRmedia\Bootstrap\Domain\Model\ContentElement>
     */
    protected $contentElements = null;


    public function getTitle(): string
    {
        return $this->title;
    }

    public function getActive(): bool
    {
        return $this->active;
    }

    public function isActive(): bool
    {
        return $this->getActive();
    }

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
