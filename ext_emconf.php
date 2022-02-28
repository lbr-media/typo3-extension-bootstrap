<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'LBRmedia Bootstrap Template',
    'description' => 'Provides Twitter Bootstrap 5 and some content elements.',
    'category' => 'templates',
    'constraints' => [
        'depends' => [
            'typo3' => '11.5.0-11.5.99',
            'seo' => '11.5.0-11.5.99'
        ],
        'conflicts' => [
            'fluid_styled_content' => '*',
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'LBRmedia\\Bootstrap\\' => 'Classes'
        ],
    ],
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 1,
    'author' => 'Marcel Briefs',
    'author_email' => 'mb@lbrmedia.de',
    'author_company' => 'LBRmedia',
    'version' => '1.0.4',
];
