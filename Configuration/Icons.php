<?php

/**
 * register icons.
 */
return [
    // ... for content elements
    'bootstrap_textimage' => [
        'provider' => \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        'source' => 'EXT:bootstrap/Resources/Public/Icons/TCA/bootstrap_textimage.svg',
    ],
    'bootstrap_mediagrid' => [
        'provider' => \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        'source' => 'EXT:bootstrap/Resources/Public/Icons/TCA/bootstrap_mediagrid.svg',
    ],
    'bootstrap_carousel' => [
        'provider' => \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        'source' => 'EXT:bootstrap/Resources/Public/Icons/TCA/bootstrap_carousel.svg',
    ],
    'bootstrap_tabs' => [
        'provider' => \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        'source' => 'EXT:bootstrap/Resources/Public/Icons/TCA/bootstrap_tabs.svg',
    ],
    'bootstrap_accordion' => [
        'provider' => \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        'source' => 'EXT:bootstrap/Resources/Public/Icons/TCA/bootstrap_accordion.svg',
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
    'bootstrap_cards' => [
        'provider' => \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        'source' => 'EXT:bootstrap/Resources/Public/Icons/TCA/bootstrap_cards.svg',
    ],

    // ... for tables
    'tx_bootstrap_domain_model_item' => [
        'provider' => \TYPO3\CMS\Core\Imaging\IconProvider\FontawesomeIconProvider::class,
        'name' => 'exclamation-triangle',
        'additionalClasses' => '',
        'spinning' => false,
    ],
    'tx_bootstrap_domain_model_accordionitem' => [
        'provider' => \TYPO3\CMS\Core\Imaging\IconProvider\FontawesomeIconProvider::class,
        'name' => 'folder-o',
        'additionalClasses' => '',
        'spinning' => false,
    ],
    'tx_bootstrap_domain_model_tabulatoritem' => [
        'provider' => \TYPO3\CMS\Core\Imaging\IconProvider\FontawesomeIconProvider::class,
        'name' => 'folder-o',
        'additionalClasses' => '',
        'spinning' => false,
    ],
    'tx_bootstrap_domain_model_carditem' => [
        'provider' => \TYPO3\CMS\Core\Imaging\IconProvider\FontawesomeIconProvider::class,
        'name' => 'folder-o',
        'additionalClasses' => '',
        'spinning' => false,
    ],
    'tx_bootstrap_domain_model_contentelement' => [
        'provider' => \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        'source' => 'EXT:bootstrap/Resources/Public/Icons/TCA/bootstrap_textmediagrid.svg',
    ],
];
