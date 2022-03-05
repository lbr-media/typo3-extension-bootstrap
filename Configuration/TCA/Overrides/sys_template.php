<?php

declare(strict_types=1);

// add TypoScript
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
