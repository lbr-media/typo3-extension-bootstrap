<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'LBRmedia Bootstrap Template',
    'description' => 'Provides Twitter Bootstrap 5 and some content elements.',
    'category' => 'templates',
    'constraints' => [
        'depends' => [
            'typo3' => '10.4.0-11.5.99',
            'seo' => '10.4.0-11.5.99'
        ],
        'conflicts' => [
            'css_styled_content' => '*',
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
    'version' => '0.0.0-dev',
];
