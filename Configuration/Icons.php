<?php

/*
* @package LBRmedia Bootstrap Template - Provides Twitter Bootstrap 5 and some content elements.
* @version 1.0.22
* @author Marcel Briefs <mb@lbrmedia.de>
* @copyright 2022 LBRmedia
* @link https://github.com/lbr-media/typo3-extension-bootstrap
* @license GPL-2.0-or-later
*/

use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;
use TYPO3\CMS\Core\Imaging\IconProvider\FontawesomeIconProvider;

return [
    // ... for content elements
    'bootstrap_textimage' => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:bootstrap/Resources/Public/Icons/TCA/bootstrap_textimage.svg',
    ],
    'bootstrap_mediagrid' => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:bootstrap/Resources/Public/Icons/TCA/bootstrap_mediagrid.svg',
    ],
    'bootstrap_carousel' => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:bootstrap/Resources/Public/Icons/TCA/bootstrap_carousel.svg',
    ],
    'bootstrap_tabs' => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:bootstrap/Resources/Public/Icons/TCA/bootstrap_tabs.svg',
    ],
    'bootstrap_accordion' => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:bootstrap/Resources/Public/Icons/TCA/bootstrap_accordion.svg',
    ],
    'bootstrap_twocolumnstext' => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:bootstrap/Resources/Public/Icons/TCA/bootstrap_twocolumnstext.svg',
    ],
    'bootstrap_textmediagrid' => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:bootstrap/Resources/Public/Icons/TCA/bootstrap_textmediagrid.svg',
    ],
    'bootstrap_textmediafloat' => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:bootstrap/Resources/Public/Icons/TCA/bootstrap_textmediafloat.svg',
    ],
    'bootstrap_cards' => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:bootstrap/Resources/Public/Icons/TCA/bootstrap_cards.svg',
    ],
    'bootstrap_alert' => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:bootstrap/Resources/Public/Icons/TCA/bootstrap_alert.svg',
    ],
    'bootstrap_markdown' => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:bootstrap/Resources/Public/Icons/TCA/bootstrap_markdown.svg',
    ],

    // ... for tables
    'tx_bootstrap_domain_model_item' => [
        'provider' => FontawesomeIconProvider::class,
        'name' => 'exclamation-triangle',
        'additionalClasses' => '',
        'spinning' => false,
    ],
    'tx_bootstrap_domain_model_accordionitem' => [
        'provider' => FontawesomeIconProvider::class,
        'name' => 'folder-o',
        'additionalClasses' => '',
        'spinning' => false,
    ],
    'tx_bootstrap_domain_model_tabulatoritem' => [
        'provider' => FontawesomeIconProvider::class,
        'name' => 'folder-o',
        'additionalClasses' => '',
        'spinning' => false,
    ],
    'tx_bootstrap_domain_model_carditem' => [
        'provider' => FontawesomeIconProvider::class,
        'name' => 'folder-o',
        'additionalClasses' => '',
        'spinning' => false,
    ],
    'tx_bootstrap_domain_model_contentelement' => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:bootstrap/Resources/Public/Icons/TCA/bootstrap_textmediagrid.svg',
    ],
];
