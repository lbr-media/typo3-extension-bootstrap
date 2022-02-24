<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Listener\TCA\Tables;

use LBRmedia\Bootstrap\Service\TcaService;

class TxBootstrapDomainModelContentElement implements TablesInterface {
    public static function process(TcaService $tcaService): void
    {
        $GLOBALS['TCA']['tx_bootstrap_domain_model_contentelement'] = [
            'ctrl' => [
                'title' => 'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:tx_bootstrap_domain_model_contentelement',
                'label' => 'header',
                'tstamp' => 'tstamp',
                'crdate' => 'crdate',
                'cruser_id' => 'cruser_id',
                'delete' => 'deleted',
                'hideTable' => true,
                'enablecolumns' => [
                    'disabled' => 'hidden',
                    'starttime' => 'starttime',
                    'endtime' => 'endtime',
                ],
                'sortby' => 'sorting',
                'searchFields' => 'title',
                'typeicon_classes' => [
                    'default' => 'tx_bootstrap_domain_model_contentelement',
                ],
            ],
            'types' => [
                '1' => [
                    'showitem' => '
                    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                    --palette--;;headers,
                    bodytext;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:bodytext_formlabel,
                    --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.media,
                    assets,
                    --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,--palette--;;frames,
                    tx_bootstrap_flexform,
                    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                    --palette--;;hidden,
                    --palette--;;access,
                    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended
                    ',
                ],
            ],
            'palettes' => [
                'headers' => [
                    'label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.headers',
                    'showitem' => '
                        header;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:header_formlabel,
                        --linebreak--,
                        header_layout;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:header_layout_formlabel,
                        tx_bootstrap_header_layout,
                        tx_bootstrap_header_predefined,
                        --linebreak--,
                        tx_bootstrap_header_color,
                        header_position;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:header_position_formlabel,
                        tx_bootstrap_header_additional_styles,
                        --linebreak--,
                        tx_bootstrap_header_icon,
                        date;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:date_formlabel,
                        --linebreak--,
                        header_link;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:header_link_formlabel,
                        --linebreak--,
                        subheader;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:subheader_formlabel
                    ',
                ],
                'hidden' => [
                    'showitem' => '
                        hidden;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:field.default.hidden
                    ',
                ],
                'access' => [
                    'label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access',
                    'showitem' => '
                        starttime;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:starttime_formlabel,
                        endtime;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:endtime_formlabel,
                        --linebreak--,
                        fe_group;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:fe_group_formlabel,
                        --linebreak--,editlock
                    ',
                ],
            ],
            'columns' => [
                'hidden' => isset($GLOBALS['TCA']['tt_content']['columns']['hidden']) ? $GLOBALS['TCA']['tt_content']['columns']['hidden'] : null,
                'starttime' => isset($GLOBALS['TCA']['tt_content']['columns']['starttime']) ? $GLOBALS['TCA']['tt_content']['columns']['starttime'] : null,
                'endtime' => isset($GLOBALS['TCA']['tt_content']['columns']['endtime']) ? $GLOBALS['TCA']['tt_content']['columns']['endtime'] : null,
                'header' => isset($GLOBALS['TCA']['tt_content']['columns']['header']) ? $GLOBALS['TCA']['tt_content']['columns']['header'] : null,
                'header_position' => isset($GLOBALS['TCA']['tt_content']['columns']['header_position']) ? $GLOBALS['TCA']['tt_content']['columns']['header_position'] : null,
                'header_layout' => isset($GLOBALS['TCA']['tt_content']['columns']['header_layout']) ? $GLOBALS['TCA']['tt_content']['columns']['header_layout'] : null,
                'header_link' => isset($GLOBALS['TCA']['tt_content']['columns']['header_link']) ? $GLOBALS['TCA']['tt_content']['columns']['header_link'] : null,
                'date' => isset($GLOBALS['TCA']['tt_content']['columns']['date']) ? $GLOBALS['TCA']['tt_content']['columns']['date'] : null,
                'subheader' => isset($GLOBALS['TCA']['tt_content']['columns']['subheader']) ? $GLOBALS['TCA']['tt_content']['columns']['subheader'] : null,
                'bodytext' => [
                    'exclude' => true,
                    'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.text',
                    'config' => [
                        'type' => 'text',
                        'cols' => 48,
                        'rows' => 6,
                        'softref' => 'typolink_tag,email[subst],url',
                        'enableRichtext' => true,
                    ],
                ],
                'assets' => isset($GLOBALS['TCA']['tt_content']['columns']['assets']) ? $GLOBALS['TCA']['tt_content']['columns']['assets'] : null,
                'space_before_class' => isset($GLOBALS['TCA']['tt_content']['columns']['space_before_class']) ? $GLOBALS['TCA']['tt_content']['columns']['space_before_class'] : null,
                'space_after_class' => isset($GLOBALS['TCA']['tt_content']['columns']['space_after_class']) ? $GLOBALS['TCA']['tt_content']['columns']['space_after_class'] : null,
                'tx_bootstrap_header_layout' => isset($GLOBALS['TCA']['tt_content']['columns']['tx_bootstrap_header_layout']) ? $GLOBALS['TCA']['tt_content']['columns']['tx_bootstrap_header_layout'] : null,
                'tx_bootstrap_header_predefined' => isset($GLOBALS['TCA']['tt_content']['columns']['tx_bootstrap_header_predefined']) ? $GLOBALS['TCA']['tt_content']['columns']['tx_bootstrap_header_predefined'] : null,
                'tx_bootstrap_header_color' => isset($GLOBALS['TCA']['tt_content']['columns']['tx_bootstrap_header_color']) ? $GLOBALS['TCA']['tt_content']['columns']['tx_bootstrap_header_color'] : null,
                'tx_bootstrap_header_additional_styles' => isset($GLOBALS['TCA']['tt_content']['columns']['tx_bootstrap_header_additional_styles']) ? $GLOBALS['TCA']['tt_content']['columns']['tx_bootstrap_header_additional_styles'] : null,
                'tx_bootstrap_header_icon' => isset($GLOBALS['TCA']['tt_content']['columns']['tx_bootstrap_header_icon']) ? $GLOBALS['TCA']['tt_content']['columns']['tx_bootstrap_header_icon'] : null,
                'tx_bootstrap_flexform' => [
                    'label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:pi_flexform',
                    'config' => [
                        'type' => 'flex',
                        // 'ds_pointerField' => '*',
                        'ds' => [
                            'default' => 'FILE:EXT:bootstrap/Configuration/FlexForms/TtContent/BootstrapTextMediaGrid.xml'
                        ],
                    ],
                ],
            ],
        ];
    }
}