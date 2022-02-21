<?php

declare(strict_types=1);

call_user_func(
    function ($extKey) {
        $GLOBALS['TCA']['sys_file_reference']['palettes']['tx_bootstrap_link'] = [
            'showitem' => 'tx_bootstrap_link_text,link',
        ];
        $GLOBALS['TCA']['sys_file_reference']['palettes']['tx_bootstrap_meta'] = [
            'showitem' => 'title,alternative,--linebreak--,description',
        ];


        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('sys_file_reference', [
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
    },
    'bootstrap'
);
