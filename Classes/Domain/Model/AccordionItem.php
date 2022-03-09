<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Items for the content element bootstrap_accordion.
 */
class AccordionItem extends AbstractEntity
{
    /**
     * @var string $title
     */
    protected $title = '';

    /**
     * @var bool $openedOnLoad
     */
    protected $openedOnLoad = false;

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
    public function getOpenedOnLoad(): bool
    {
        return $this->openedOnLoad;
    }

    /**
     * @return bool
     */
    public function isOpenedOnLoad(): bool
    {
        return $this->getOpenedOnLoad();
    }

    /**
     * @return ObjectStorage<ContentElement>
     */
    public function getContentElements(): ObjectStorage
    {
        return $this->contentElements;
    }
}
