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
        '\LBRmedia\Bootstrap\Listener\TCA\TtContent\NewContentElement\BootstrapTextImage',
        '\LBRmedia\Bootstrap\Listener\TCA\TtContent\NewContentElement\BootstrapMediaGrid',
        '\LBRmedia\Bootstrap\Listener\TCA\TtContent\NewContentElement\BootstrapCarousel',
        '\LBRmedia\Bootstrap\Listener\TCA\TtContent\NewContentElement\BootstrapTabs',
        '\LBRmedia\Bootstrap\Listener\TCA\TtContent\NewContentElement\BootstrapAccordion',
        '\LBRmedia\Bootstrap\Listener\TCA\TtContent\NewContentElement\BootstrapTwoColumnsText',
        '\LBRmedia\Bootstrap\Listener\TCA\TtContent\NewContentElement\BootstrapTextMediaGrid',
        '\LBRmedia\Bootstrap\Listener\TCA\TtContent\NewContentElement\BootstrapTextMediaFloat',
        '\LBRmedia\Bootstrap\Listener\TCA\TtContent\NewContentElement\BootstrapCards',
        '\LBRmedia\Bootstrap\Listener\TCA\TtContent\NewContentElement\BootstrapAlert',
        '\LBRmedia\Bootstrap\Listener\TCA\TtContent\NewContentElement\BootstrapMarkdown',

        // This default content element must be modified at the very last element b/c other ce copies it!
        // It is disabled by default and only used to be a fallback of the BootstrapTextMediaFloat content element.
        '\LBRmedia\Bootstrap\Listener\TCA\TtContent\NewContentElement\TextMedia',
        '\LBRmedia\Bootstrap\Listener\TCA\TtContent\NewContentElement\Text',
    ];

    protected $tcaService;

    public function injectTcaService(TcaService $tcaService)
    {
        $this->tcaService = $tcaService;
    }

    public function __invoke(AfterTcaCompilationEvent $event): void
    {
        foreach (self::NEW_CONTENT_ELEMENT_CLASSES as $className) {
            if (!in_array(NewContentElementInterface::class, class_implements($className), true)) {
                throw new InvalidArgumentException($className . ' does not implement NewContentElementInterface!', 1626331595);
            }

            call_user_func($className . '::addPlugin', $this->tcaService);
        }

        $event->setTca($GLOBALS['TCA']);
    }
}
