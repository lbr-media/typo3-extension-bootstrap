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

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') or die();

/**
 * Add styles for backend
 */
$GLOBALS['TBE_STYLES']['skins']['app'] = [
    'name' => 'bootstrap',
    'stylesheetDirectories' => [
        'structure' => 'EXT:bootstrap/Resources/Public/Stylesheets/Backend/',
    ],
];

/**
 * Allow tables
 */
ExtensionManagementUtility::allowTableOnStandardPages('tx_bootstrap_domain_model_accordionitem');
ExtensionManagementUtility::allowTableOnStandardPages('tx_bootstrap_domain_model_tabulatoritem');
ExtensionManagementUtility::allowTableOnStandardPages('tx_bootstrap_domain_model_contentelement');
ExtensionManagementUtility::allowTableOnStandardPages('tx_bootstrap_domain_model_carditem');
