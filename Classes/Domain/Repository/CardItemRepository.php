<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Domain\Repository;

use LBRmedia\Bootstrap\Domain\Model\CardItem;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResult;
use TYPO3\CMS\Extbase\Persistence\Repository;

class CardItemRepository extends Repository
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
     * @return QueryResult<CardItem>
     */
    public function findByRelation(string $relationFieldName, int $relationUid): ?object
    {
        $query = $this->createQuery();
        $query->matching($query->equals($relationFieldName, $relationUid));

        return $query->execute();
    }
}
