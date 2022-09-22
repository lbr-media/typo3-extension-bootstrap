<?php

declare(strict_types=1);

/*
 * @package LBRmedia Bootstrap Template - Provides Twitter Bootstrap 5 and some content elements.
 * @version 1.0.23
 * @author Marcel Briefs <mb@lbrmedia.de>
 * @copyright 2022 LBRmedia
 * @link https://github.com/lbr-media/typo3-extension-bootstrap
 * @license GPL-2.0-or-later
 */

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

$GLOBALS['TCA']['sys_file_reference']['palettes']['tx_bootstrap_link'] = [
    'showitem' => 'tx_bootstrap_link_text,link',
];
$GLOBALS['TCA']['sys_file_reference']['palettes']['tx_bootstrap_meta'] = [
    'showitem' => 'title,alternative,--linebreak--,description',
];

ExtensionManagementUtility::addTCAcolumns('sys_file_reference', [
    'tx_bootstrap_header' => [
        'label' => 'Überschrift',
        'config' => [
            'type' => 'text',
            'cols' => 20,
            'rows' => 3,
            'eval' => 'trim',
        ],
    ],
    'tx_bootstrap_link_text' => [
        'label' => 'Button-Text',
        'config' => [
            'type' => 'input',
            'size' => 20,
            'eval' => 'trim',
        ],
    ],
]);
