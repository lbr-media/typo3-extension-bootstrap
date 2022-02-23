<?php

declare(strict_types=1);

// Prevent Script from being called directly
defined('TYPO3') or die();

/**
 * Add styles for backend
 */
$GLOBALS['TBE_STYLES']['skins']['app'] = [
    'name' => "bootstrap",
    'stylesheetDirectories' => [
        'structure' => 'EXT:bootstrap/Resources/Public/Stylesheets/Backend/',
    ]
];

/**
 * Allow tables
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_bootstrap_domain_model_item');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_bootstrap_domain_model_teammember');
// \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_bootstrap_domain_model_accordionitem');
