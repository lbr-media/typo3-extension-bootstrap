<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Listener\TCA\TtContent;

use InvalidArgumentException;
use LBRmedia\Bootstrap\Listener\TCA\TtContent\NewContentElement\NewContentElementInterface;
use LBRmedia\Bootstrap\Service\TcaService;
use TYPO3\CMS\Core\Configuration\Event\AfterTcaCompilationEvent;

/**
 * EventListener which will be called after all TCA is build.
 * It calls itselfs all content element definitions (classes defined in self::NEW_CONTENT_ELEMENT_CLASSES).
 * After that the TCA will be restored.
 */
class NewContentElement
{
    const NEW_CONTENT_ELEMENT_CLASSES = [
        // '\LBRmedia\Bootstrap\Listener\TCA\TtContent\NewContentElement\TextMedia',
        '\LBRmedia\Bootstrap\Listener\TCA\TtContent\NewContentElement\BootstrapType1',
        '\LBRmedia\Bootstrap\Listener\TCA\TtContent\NewContentElement\BootstrapType2',
        '\LBRmedia\Bootstrap\Listener\TCA\TtContent\NewContentElement\BootstrapType3',
        '\LBRmedia\Bootstrap\Listener\TCA\TtContent\NewContentElement\BootstrapType4',
        '\LBRmedia\Bootstrap\Listener\TCA\TtContent\NewContentElement\BootstrapType5',
        '\LBRmedia\Bootstrap\Listener\TCA\TtContent\NewContentElement\BootstrapType6',
        '\LBRmedia\Bootstrap\Listener\TCA\TtContent\NewContentElement\BootstrapType7',
        '\LBRmedia\Bootstrap\Listener\TCA\TtContent\NewContentElement\BootstrapTextMediaGrid',
        '\LBRmedia\Bootstrap\Listener\TCA\TtContent\NewContentElement\BootstrapTextMediaFloat',
    ];

    protected $tcaService = null;

    public function injectTcaService(TcaService $tcaService)
    {
        $this->tcaService = $tcaService;
    }

    public function __invoke(AfterTcaCompilationEvent $event): void
    {
        foreach (self::NEW_CONTENT_ELEMENT_CLASSES as $className) {
            if (!in_array(NewContentElementInterface::class, class_implements($className), true)) {
                throw new InvalidArgumentException('NewContentElement/'.$className.' implement NewContentElementInterface', 1626331595);
            }

            call_user_func($className.'::addPlugin', $this->tcaService);
        }

        $event->setTca($GLOBALS['TCA']);
    }
}