<?php

/*
 * @package LBRmedia Bootstrap Template - Provides Twitter Bootstrap 5 and some content elements.
 * @version 12.0.0
 * @author Marcel Briefs <mb@lbrmedia.de>
 * @copyright 2022 LBRmedia
 * @link https://github.com/lbr-media/typo3-extension-bootstrap
 * @license GPL-2.0-or-later
 */

$EM_CONF[$_EXTKEY] = [
    'title' => 'LBRmedia Bootstrap Template',
    'description' => 'Provides Twitter Bootstrap 5 and some content elements.',
    'category' => 'templates',
    'constraints' => [
        'depends' => [
            'typo3' => '12.0.0-12.5.99',
            'seo' => '12.0.0-12.5.99',
        ],
        'conflicts' => [
            'fluid_styled_content' => '*',
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'LBRmedia\\Bootstrap\\' => 'Classes',
        ],
    ],
    'state' => 'stable',
    'clearCacheOnLoad' => true,
    'author' => 'Marcel Briefs',
    'author_email' => 'mb@lbrmedia.de',
    'author_company' => 'LBRmedia',
    'version' => '12.0.0',
];
