<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Listener\TCA;

use TYPO3\CMS\Core\Configuration\Event\AfterTcaCompilationEvent;

/**
 * Load TCA tables configurations after all is set.
 */
class Tables
{
    public function __invoke(AfterTcaCompilationEvent $event): void
    {
        $GLOBALS['TCA']['tx_bootstrap_domain_model_contentelement'] = include_once "tx_bootstrap_domain_model_contentelement.php";

        // restore TCA
        $event->setTca($GLOBALS['TCA']);
    }
}
