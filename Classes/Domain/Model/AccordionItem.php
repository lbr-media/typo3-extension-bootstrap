<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Items for the content element bootstrap_accordion.
 */
class AccordionItem extends AbstractEntity
{
    /**
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $title = '';

    /**
     * @var bool
     */
    protected $openedOnLoad = false;

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
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\LBRmedia\Bootstrap\Domain\Model\ContentElement>
     */
    public function getContentElements(): \TYPO3\CMS\Extbase\Persistence\ObjectStorage
    {
        return $this->contentElements;
    }
}
