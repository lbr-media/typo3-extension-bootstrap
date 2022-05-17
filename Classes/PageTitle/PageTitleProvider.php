<?php

declare(strict_types=1);

/*
 * @package LBRmedia Bootstrap Template - Provides Twitter Bootstrap 5 and some content elements.
 * @version 1.0.22
 * @author Marcel Briefs <mb@lbrmedia.de>
 * @copyright 2022 LBRmedia
 * @link https://github.com/lbr-media/typo3-extension-bootstrap
 * @license GPL-2.0-or-later
 */

namespace LBRmedia\Bootstrap\PageTitle;

use LBRmedia\Bootstrap\Utility\GeneralUtility;
use TYPO3\CMS\Core\PageTitle\AbstractPageTitleProvider;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

class PageTitleProvider extends AbstractPageTitleProvider
{
    public function __construct()
    {
        if ($GLOBALS['TSFE']->page['seo_title']) {
            $this->title = (string)$GLOBALS['TSFE']->page['seo_title'];
        } else {
            /**
             * When seo_title isn't set, prefix and suffix the title with the content objects defined in config.seo_title_is_empty.prefix and config.seo_title_is_empty.suffix.
             */
            $prefix = '';
            $suffix = '';
            $setup = GeneralUtility::getConfigurationManager()->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);

            if (isset($setup['config.']['seo_title_is_empty.']) && is_array($setup['config.']['seo_title_is_empty.'])) {
                // render prefix
                if (
                    isset($setup['config.']['seo_title_is_empty.']['prefix']) &&
                    $setup['config.']['seo_title_is_empty.']['prefix'] &&
                    isset($setup['config.']['seo_title_is_empty.']['prefix.']) &&
                    is_array($setup['config.']['seo_title_is_empty.']['prefix.'])
                ) {
                    $prefix = GeneralUtility::getContentObjectRenderer()->cObjGetSingle($setup['config.']['seo_title_is_empty.']['prefix'], $setup['config.']['seo_title_is_empty.']['prefix.'], 'config.seo_title_is_empty.prefix');
                }

                // render suffix
                if (
                    isset($setup['config.']['seo_title_is_empty.']['suffix']) &&
                    $setup['config.']['seo_title_is_empty.']['suffix'] &&
                    isset($setup['config.']['seo_title_is_empty.']['suffix.']) &&
                    is_array($setup['config.']['seo_title_is_empty.']['suffix.'])
                ) {
                    $suffix = GeneralUtility::getContentObjectRenderer()->cObjGetSingle($setup['config.']['seo_title_is_empty.']['suffix'], $setup['config.']['seo_title_is_empty.']['suffix.'], 'config.seo_title_is_empty.suffix');
                }
            }

            // prepend context string when not in production to see it in the browser tab
            $context = 'Production' !== \TYPO3\CMS\Core\Core\Environment::getContext()->__toString()
                ? '(' . \TYPO3\CMS\Core\Core\Environment::getContext()->__toString() . ') '
                : '';

            $this->title = (string)$context . $prefix . $GLOBALS['TSFE']->page['title'] . $suffix;
        }
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
}
