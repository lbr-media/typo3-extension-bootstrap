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

use LBRmedia\Bootstrap\Form\Element\AllEdgesElement;
use LBRmedia\Bootstrap\Form\Element\BootstrapBorderElement;
use LBRmedia\Bootstrap\Form\Element\BootstrapDevicesElement;
use LBRmedia\Bootstrap\Form\Element\BootstrapIconsElement;
use LBRmedia\Bootstrap\Hooks\IconSet;
use LBRmedia\Bootstrap\Utility\BootstrapUtility;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') or die();

/**
 * add RTE configuration
 * TODO@sunixzs https://github.com/lbr-media/typo3-extension-bootstrap/issues/13 Check RTE configuration for v12
 */
// $GLOBALS['TYPO3_CONF_VARS']['RTE']['Presets']['BOOTSTRAP'] = 'EXT:bootstrap/Configuration/RichTextEditor/Standard.yaml';

/**
 * add User TsConfig
 */
ExtensionManagementUtility::addUserTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:bootstrap/Configuration/TsConfig/User/General.typoscript">');

/*
 * Add renderTypes
 */
// Add renderType bootstrapDevices to NodeFactory
$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][1645456748] = [
    'nodeName' => 'bootstrapDevices',
    'priority' => '70',
    'class' => BootstrapDevicesElement::class,
];

// Add renderType allEdges to NodeFactory
$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][1645456749] = [
    'nodeName' => 'allEdges',
    'priority' => '70',
    'class' => AllEdgesElement::class,
];

// Add renderType allEdges to NodeFactory
$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][1646131736] = [
    'nodeName' => 'bootstrapBorder',
    'priority' => '70',
    'class' => BootstrapBorderElement::class,
];

// Add renderType allEdges to NodeFactory
$GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][1646200749] = [
    'nodeName' => 'bootstrapIcons',
    'priority' => '70',
    'class' => BootstrapIconsElement::class,
];

// Define TypoScript as content rendering template
$GLOBALS['TYPO3_CONF_VARS']['FE']['contentRenderingTemplates'][] = 'bootstrap/Configuration/TypoScript/Content/';

// Get the context and make it visible in backend
$GLOBALS['TYPO3_CONF_VARS']['SYS']['sitename'] = '(' . (string)Environment::getContext()->__toString() . ') ' . $GLOBALS['TYPO3_CONF_VARS']['SYS']['sitename'];

// Register icon set hook for frontend
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][BootstrapUtility::class]['renderIconSet'][] = IconSet::class . '->getBootstrapIconMarkup';

// Register icon set hook for backend javascript
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][BootstrapIconsElement::class]['formElement'][] = 'TYPO3/CMS/Bootstrap/FormEngine/Element/BootstrapIconsElementBootstrapIconsHook';
