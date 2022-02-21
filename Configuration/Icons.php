<?php

/**
 * register icons.
 */
return [
    // ... for content elements
    'bootstrap_type1' => [
        'provider' => \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        'source' => 'EXT:bootstrap/Resources/Public/Icons/TCA/bootstrap_type1.svg',
    ],
    'bootstrap_type2' => [
        'provider' => \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        'source' => 'EXT:bootstrap/Resources/Public/Icons/TCA/bootstrap_type2.svg',
    ],
    'bootstrap_type3' => [
        'provider' => \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        'source' => 'EXT:bootstrap/Resources/Public/Icons/TCA/bootstrap_type3.svg',
    ],
    'bootstrap_type4' => [
        'provider' => \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        'source' => 'EXT:bootstrap/Resources/Public/Icons/TCA/bootstrap_type4.svg',
    ],
    'bootstrap_type5' => [
        'provider' => \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        'source' => 'EXT:bootstrap/Resources/Public/Icons/TCA/bootstrap_type5.svg',
    ],
    'bootstrap_type6' => [
        'provider' => \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        'source' => 'EXT:bootstrap/Resources/Public/Icons/TCA/bootstrap_type6.svg',
    ],
    'bootstrap_type7' => [
        'provider' => \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        'source' => 'EXT:bootstrap/Resources/Public/Icons/TCA/bootstrap_type7.svg',
    ],

    // ... for tables
    'tx_bootstrap_domain_model_item' => [
        'provider' => \TYPO3\CMS\Core\Imaging\IconProvider\FontawesomeIconProvider::class,
        'name' => 'exclamation-triangle',
        'additionalClasses' => '',
        'spinning' => false,
    ],
    'tx_bootstrap_domain_model_teammember' => [
        'provider' => \TYPO3\CMS\Core\Imaging\IconProvider\FontawesomeIconProvider::class,
        'name' => 'user',
        'additionalClasses' => '',
        'spinning' => false,
    ],
];
