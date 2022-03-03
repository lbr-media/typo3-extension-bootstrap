<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Items for the accordion content element
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

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getOpenedOnLoad(): bool
    {
        return $this->openedOnLoad;
    }

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
