<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * The repository for content element bootstrap_accordion
 */
class AccordionItemRepository extends Repository
{
    /**
     * @var array
     */
    protected $defaultOrderings = [
        'sorting' => QueryInterface::ORDER_ASCENDING,
    ];

    /**
     * @var Typo3QuerySettings
     */
    protected $querySettings = null;

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
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResult<\LBRmedia\Bootstrap\Domain\Model\AccordionItem>
     */
    public function findByRelation(string $relationFieldName, int $relationUid): ?object
    {
        $query = $this->createQuery();
        $query->matching($query->equals($relationFieldName, $relationUid));

        return $query->execute();
    }
}
