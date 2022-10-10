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

namespace LBRmedia\Bootstrap\Listener\TCA\Tables;

use InvalidArgumentException;
use LBRmedia\Bootstrap\Service\TcaService;
use TYPO3\CMS\Core\Configuration\Event\AfterTcaCompilationEvent;

/**
 * Load TCA tables configurations after all is set.
 */
class Tables
{
    const TABLE_CLASSES = [
        '\LBRmedia\Bootstrap\Listener\TCA\Tables\TxBootstrapDomainModelContentElement',
    ];

    protected $tcaService;

    public function injectTcaService(TcaService $tcaService)
    {
        $this->tcaService = $tcaService;
    }

    public function __invoke(AfterTcaCompilationEvent $event): void
    {
        foreach (self::TABLE_CLASSES as $className) {
            if (!in_array(TablesInterface::class, class_implements($className), true)) {
                throw new InvalidArgumentException($className . ' does not implement TablesInterface!', 1626331596);
            }

            call_user_func($className . '::process', $this->tcaService);
        }

        $event->setTca($GLOBALS['TCA']);
    }
}
