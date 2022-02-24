<?php

declare(strict_types=1);

call_user_func(
    function ($extKey) {
        // add TypoScript
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
            $extKey,
            'Configuration/TypoScript',
            'General'
        );

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
            $extKey,
            'Configuration/TypoScript/Content',
            'Content elements'
        );

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
            $extKey,
            'Configuration/TypoScript/Styles',
            'Additional Styles'
        );
    },
    'bootstrap'
);
