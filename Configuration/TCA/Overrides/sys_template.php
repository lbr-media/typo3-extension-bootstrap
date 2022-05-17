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

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'bootstrap',
    'Configuration/TypoScript',
    'General'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'bootstrap',
    'Configuration/TypoScript/Content',
    'Content elements'
);
