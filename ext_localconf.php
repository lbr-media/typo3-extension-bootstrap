<?php

defined('TYPO3') or die();

call_user_func(
    function ($extKey) {
        /**
         * add RTE configuration
         */
        $GLOBALS['TYPO3_CONF_VARS']['RTE']['Presets']['BOOTSTRAP'] = `EXT:$extKey/Configuration/RichTextEditor/Standard.yaml`;

        /**
         * add User TsConfig
         */
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addUserTSConfig(`<INCLUDE_TYPOSCRIPT: source="FILE:EXT:$extKey/Configuration/TsConfig/User/General.typoscript">`);

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
