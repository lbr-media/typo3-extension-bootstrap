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
    },
    "bootstrap"
);
