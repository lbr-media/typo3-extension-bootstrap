<?php

declare(strict_types=1);

defined('TYPO3') or die();

call_user_func(
    function ($extKey) {
        /**
         * add RTE configuration
         */
        $GLOBALS['TYPO3_CONF_VARS']['RTE']['Presets']['BOOTSTRAP'] = "EXT:$extKey/Configuration/RichTextEditor/Standard.yaml";

        /**
         * add User TsConfig
         */
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addUserTSConfig("<INCLUDE_TYPOSCRIPT: source=\"FILE:EXT:$extKey/Configuration/TsConfig/User/General.typoscript\">");

        /*
         * configure plugins
         */
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            $extKey,
            'ItemList',
            [\LBRmedia\Bootstrap\Controller\ItemController::class => 'overview']
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            $extKey,
            'ItemDetails',
            [\LBRmedia\Bootstrap\Controller\ItemController::class => 'details']
        );

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
    },
    "bootstrap"
);

// Define TypoScript as content rendering template
$GLOBALS['TYPO3_CONF_VARS']['FE']['contentRenderingTemplates'][] = 'bootstrap/Configuration/TypoScript/';
