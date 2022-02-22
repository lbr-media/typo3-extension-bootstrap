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
    'bootstrap_mediagrid' => [
        'provider' => \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        'source' => 'EXT:bootstrap/Resources/Public/Icons/TCA/bootstrap_mediagrid.svg',
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
    'bootstrap_twocolumnstext' => [
        'provider' => \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        'source' => 'EXT:bootstrap/Resources/Public/Icons/TCA/bootstrap_twocolumnstext.svg',
    ],
    'bootstrap_textmediagrid' => [
        'provider' => \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        'source' => 'EXT:bootstrap/Resources/Public/Icons/TCA/bootstrap_textmediagrid.svg',
    ],
    'bootstrap_textmediafloat' => [
        'provider' => \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        'source' => 'EXT:bootstrap/Resources/Public/Icons/TCA/bootstrap_textmediafloat.svg',
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
