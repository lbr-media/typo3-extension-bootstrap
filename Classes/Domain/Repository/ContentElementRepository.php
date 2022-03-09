<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * The repository for bootstrap_textmediagrid like content elements.
 */
class ContentElementRepository extends Repository
{
    /**
     * @var array $defaultOrderings
     */
    protected $defaultOrderings = [
        'sorting' => QueryInterface::ORDER_ASCENDING,
    ];
}
