<?php

declare(strict_types=1);

/*
 * @package LBRmedia Bootstrap Template - Provides Twitter Bootstrap 5 and some content elements.
 * @version 1.0.23
 * @author Marcel Briefs <mb@lbrmedia.de>
 * @copyright 2022 LBRmedia
 * @link https://github.com/lbr-media/typo3-extension-bootstrap
 * @license GPL-2.0-or-later
 */

namespace LBRmedia\Bootstrap\Domain\Repository;

use LBRmedia\Bootstrap\Domain\Model\TabulatorItem;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResult;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * The repository for content element bootstrap_tabs.
 */
class TabulatorItemRepository extends Repository
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
    public function injectQuerySettings(Typo3QuerySettings $querySettings)
    {
        $this->querySettings = $querySettings;
    }

    /**
     * initializes this repository.
     */
    public function initializeObject(): void
    {
        $this->querySettings->setRespectStoragePage(false);
        $this->setDefaultQuerySettings($this->querySettings);
    }

    /**
     * @return QueryResult<TabulatorItem>
     */
    public function findByRelation(string $relationFieldName, int $relationUid): ?object
    {
        $query = $this->createQuery();
        $query->matching($query->equals($relationFieldName, $relationUid));

        return $query->execute();
    }
}
