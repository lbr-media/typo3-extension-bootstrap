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

namespace LBRmedia\Bootstrap\Domain\Repository;

use LBRmedia\Bootstrap\Domain\Model\AccordionItem;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResult;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * The repository for content element bootstrap_accordion.
 */
class AccordionItemRepository extends Repository
{
    /**
     * @var array $defaultOrderings
     */
    protected $defaultOrderings = [
        'sorting' => QueryInterface::ORDER_ASCENDING,
    ];

    /**
     * @var Typo3QuerySettings $querySettings
     */
    protected $querySettings;

    /**
     * @param Typo3QuerySettings $querySettings
     */
    public function injectQuerySettings(Typo3QuerySettings $querySettings): void
    {
        $this->querySettings = $querySettings;
    }

    /**
     * Initializes this repository.
     */
    public function initializeObject(): void
    {
        $this->querySettings->setRespectStoragePage(false);
        $this->setDefaultQuerySettings($this->querySettings);
    }

    /**
     * @param string $relationFieldName
     * @param int  $relationUid
     *
     * @return QueryResult<AccordionItem>
     */
    public function findByRelation(string $relationFieldName, int $relationUid): ?object
    {
        $query = $this->createQuery();
        $query->matching($query->equals($relationFieldName, $relationUid));

        return $query->execute();
    }
}
