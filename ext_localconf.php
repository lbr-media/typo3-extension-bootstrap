<?php

declare(strict_types=1);

defined('TYPO3') or die();

/**
 * add RTE configuration
 */
$GLOBALS['TYPO3_CONF_VARS']['RTE']['Presets']['BOOTSTRAP'] = 'EXT:bootstrap/Configuration/RichTextEditor/Standard.yaml';

/**
 * add User TsConfig
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addUserTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:bootstrap/Configuration/TsConfig/User/General.typoscript">');

/*
 * Add renderTypes
 */
// Add renderType bootstrapDevices to NodeFactory
$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][1645456748] = [
    'nodeName' => 'bootstrapDevices',
    'priority' => '70',
    'class' => \LBRmedia\Bootstrap\Form\Element\BootstrapDevicesElement::class,
];

// Add renderType allEdges to NodeFactory
$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][1645456749] = [
    'nodeName' => 'allEdges',
    'priority' => '70',
    'class' => \LBRmedia\Bootstrap\Form\Element\AllEdgesElement::class,
];

// Add renderType allEdges to NodeFactory
$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][1646131736] = [
    'nodeName' => 'bootstrapBorder',
    'priority' => '70',
    'class' => \LBRmedia\Bootstrap\Form\Element\BootstrapBorderElement::class,
];

// Add renderType allEdges to NodeFactory
$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][1646200749] = [
    'nodeName' => 'bootstrapIcons',
    'priority' => '70',
    'class' => \LBRmedia\Bootstrap\Form\Element\BootstrapIconsElement::class,
];

// Define TypoScript as content rendering template
$GLOBALS['TYPO3_CONF_VARS']['FE']['contentRenderingTemplates'][] = 'bootstrap/Configuration/TypoScript/Content/';

// Get the context and make it visible in backend
$GLOBALS['TYPO3_CONF_VARS']['SYS']['sitename'] = '(' . (string)\TYPO3\CMS\Core\Core\Environment::getContext()->__toString() . ') ' . $GLOBALS['TYPO3_CONF_VARS']['SYS']['sitename'];
