<?php

declare(strict_types=1);

/*
 * @package LBRmedia Bootstrap Template - Provides Twitter Bootstrap 5 and some content elements.
 * @version 1.0.17
 * @author Marcel Briefs <mb@lbrmedia.de>
 * @copyright 2022 LBRmedia
 * @link https://github.com/lbr-media/typo3-extension-bootstrap
 * @license GPL-2.0-or-later
 */

namespace LBRmedia\Bootstrap\UserFunc;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

class Tag
{
    /**
     * Renders the starting html-tag.
     * Automatically sets classes for:
     * - page.uid
     * - page.pid
     * - page.sys_language_uid
     * - page.tx_base_layout_variant.
     *
     * @see Have a lock at self::tag() for configuration parameters.
     *
     * @return string The HTML-Tag
     */
    public function html(string $content = '', array $conf = []): string
    {
        // set some classes always shown in html tag
        $classes = [];
        $classes[] = 'page-uid-' . $GLOBALS['TSFE']->page['uid'];
        $classes[] = 'parent-page-uid-' . $GLOBALS['TSFE']->page['pid'];
        $classes[] = 'language-' . $GLOBALS['TSFE']->page['sys_language_uid'];
        if (isset($GLOBALS['TSFE']->page['tx_base_layout_variant']) && $GLOBALS['TSFE']->page['tx_base_layout_variant']) {
            $classes[] = $GLOBALS['TSFE']->page['tx_base_layout_variant'];
        }

        // add them to the additionalClasses from configuration
        if (!isset($conf['additionalClasses.']) && !is_array($conf['additionalClasses.'])) {
            $conf['additionalClasses.'] = [];
        }
        $conf['additionalClasses.'] = array_merge($conf['additionalClasses.'], $classes);

        // render the tag
        return $this->tag('html', $content, $conf);
    }

    /**
     * Renders the starting body-tag.
     *
     * @see Have a lock at self::tag() for configuration parameters.
     *
     * @return string The BODY-Tag
     */
    public function body(string $content = '', array $conf = []): string
    {
        // render the tag
        return $this->tag('body', $content, $conf);
    }

    /**
     * Renders a tag
     * - sets lang attribute
     * - accepts configuration for:
     *      - additionalClasses
     *          array with classes to add
     *      - additionalClassCObject
     *          cObject to add a class p.e. to add the current backend layout:
     *          additionalClassCObject = TEXT
     *          additionalClassCObject {
     *              data = pagelayout
     *              split {
     *                  token = pagets__
     *              }
     *              wrap = page-layout-|
     *          }
     *      - additionalAttributes
     *          array with attribute = value pairs.
     *      - langAttribute = some two letter laguage code to overwrite $GLOBALS['TSFE']->getLanguage()->getTwoLetterIsoCode().
     *
     * @return string The BODY-Tag
     */
    public function tag(string $tagName, string $content = '', array $conf = []): string
    {
        // TODO: implement TagBuilder
        $tag = '<' . $tagName;

        // set lang attribute
        $tag .= ' lang="' . (isset($conf['langAttribute']) ? trim($conf['langAttribute']) : $GLOBALS['TSFE']->getLanguage()->getTwoLetterIsoCode()) . '"';

        // set some classes
        $classes = [];
        if (isset($conf['additionalClasses.']) && is_array($conf['additionalClasses.'])) {
            $classes = array_merge($classes, $conf['additionalClasses.']);
        }

        if (isset($conf['additionalClassCObject']) && is_string($conf['additionalClassCObject']) && isset($conf['additionalClassCObject.']) && is_array($conf['additionalClassCObject.'])) {
            $contentObjectRenderer = GeneralUtility::makeInstance(ContentObjectRenderer::class, $GLOBALS['TSFE']);
            $classes[] = $contentObjectRenderer->cObjGetSingle($conf['additionalClassCObject'], $conf['additionalClassCObject.']);
        }

        if (count($classes)) {
            $tag .= ' class="' . implode(' ', $classes) . '"';
        }

        // additional attributes
        if (isset($conf['additionalAttributes.']) && is_array($conf['additionalAttributes.'])) {
            foreach ($conf['additionalAttributes.'] as $attribute => $value) {
                $tag .= ' ' . $attribute . '="' . htmlspecialchars($value) . '"';
            }
        }

        return $tag . '>';
    }
}
