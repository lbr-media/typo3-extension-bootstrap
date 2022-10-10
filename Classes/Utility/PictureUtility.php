<?php

declare(strict_types=1);

/*
 * @package LBRmedia Bootstrap Template - Provides Twitter Bootstrap 5 and some content elements.
 * @version 12.0.0
 * @author Marcel Briefs <mb@lbrmedia.de>
 * @copyright 2022 LBRmedia
 * @link https://github.com/lbr-media/typo3-extension-bootstrap
 * @license GPL-2.0-or-later
 */

namespace LBRmedia\Bootstrap\Utility;

class PictureUtility
{
    public const ALLOWED_ASPECT_RATIOS = [
        'NaN' => [
            'title' => 'frei',
            'value' => 0.0,
        ],
        '21:10' => [
            'title' => '21:10',
            'value' => 21 / 10,
        ],
        '21:9' => [
            'title' => '21:9',
            'value' => 21 / 9,
        ],
        '16:10' => [
            'title' => '16:10',
            'value' => 16 / 10,
        ],
        '16:9' => [
            'title' => '16:9',
            'value' => 16 / 9,
        ],
        '9:16' => [
            'title' => '9:16',
            'value' => 9 / 16,
        ],
        '3:4' => [
            'title' => '3:4',
            'value' => 3 / 4,
        ],
        '4:3' => [
            'title' => '4:3',
            'value' => 4 / 3,
        ],
        '2:3' => [
            'title' => '2:3',
            'value' => 2 / 3,
        ],
        '3:2' => [
            'title' => '3:2',
            'value' => 3 / 2,
        ],
        '5:7' => [
            'title' => '5:7',
            'value' => 5 / 7,
        ],
        '7:5' => [
            'title' => '7:5',
            'value' => 7 / 5,
        ],
        '4:5' => [
            'title' => '4:5',
            'value' => 4 / 5,
        ],
        '5:4' => [
            'title' => '5:4',
            'value' => 5 / 3,
        ],
        '1:2' => [
            'title' => '1:2',
            'value' => 1 / 2,
        ],
        '2:1' => [
            'title' => '2:1',
            'value' => 2 / 1,
        ],
        '1:1' => [
            'title' => '1:1',
            'value' => 1 / 1,
        ],
    ];

    public const ALLOWED_ASPECT_RATIOS_SOCIAL_MEDIA = [
        'NaN' => self::ALLOWED_ASPECT_RATIOS['NaN'],
        '120:63' => [
            'title' => '1.91:1 (Facebook)',
            'value' => 120 / 63,
        ],
        '2:1' => self::ALLOWED_ASPECT_RATIOS['2:1'],
        '1:1' => self::ALLOWED_ASPECT_RATIOS['1:1'],
    ];

    public const ALLOWED_ASPECT_RATIOS_PAGES_MEDIA = [
        'NaN' => self::ALLOWED_ASPECT_RATIOS['NaN'],
        '9:16' => [
            'title' => 'XS (9:16)',
            'value' => 9 / 16,
        ],
        '16:9' => [
            'title' => 'SM-XXL (16:9)',
            'value' => 16 / 9,
        ],
    ];

    public const CROP_VARIANTS = [
        'default' => [
            'title' => 'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:cropVariants.default',
            'selectedRatio' => 'NaN',
            'allowedAspectRatios' => self::ALLOWED_ASPECT_RATIOS,
        ],
        'xs' => [
            'title' => 'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:cropVariants.xs',
            'selectedRatio' => 'NaN',
            'allowedAspectRatios' => self::ALLOWED_ASPECT_RATIOS,
        ],
        'sm' => [
            'title' => 'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:cropVariants.sm',
            'selectedRatio' => 'NaN',
            'allowedAspectRatios' => self::ALLOWED_ASPECT_RATIOS,
        ],
        'md' => [
            'title' => 'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:cropVariants.md',
            'selectedRatio' => 'NaN',
            'allowedAspectRatios' => self::ALLOWED_ASPECT_RATIOS,
        ],
        'lg' => [
            'title' => 'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:cropVariants.lg',
            'selectedRatio' => 'NaN',
            'allowedAspectRatios' => self::ALLOWED_ASPECT_RATIOS,
        ],
        'xl' => [
            'title' => 'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:cropVariants.xl',
            'selectedRatio' => 'NaN',
            'allowedAspectRatios' => self::ALLOWED_ASPECT_RATIOS,
        ],
        'xxl' => [
            'title' => 'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:cropVariants.xxl',
            'selectedRatio' => 'NaN',
            'allowedAspectRatios' => self::ALLOWED_ASPECT_RATIOS,
        ],
        'lightbox' => [
            'title' => 'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:cropVariants.lightbox',
            'selectedRatio' => 'NaN',
            'allowedAspectRatios' => self::ALLOWED_ASPECT_RATIOS,
        ],
        'navigation' => [
            'title' => 'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:cropVariants.navigation',
            'selectedRatio' => '1:1',
            'allowedAspectRatios' => self::ALLOWED_ASPECT_RATIOS,
        ],
        'social' => [
            'title' => 'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:cropVariants.social',
            'selectedRatio' => 'NaN',
            'allowedAspectRatios' => self::ALLOWED_ASPECT_RATIOS_SOCIAL_MEDIA,
        ],
        'pages_media_xs' => [
            'title' => 'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:cropVariants.xs',
            'selectedRatio' => '9:16',
            'allowedAspectRatios' => self::ALLOWED_ASPECT_RATIOS_PAGES_MEDIA,
        ],
        'pages_media_sm' => [
            'title' => 'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:cropVariants.sm',
            'selectedRatio' => '16:9',
            'allowedAspectRatios' => self::ALLOWED_ASPECT_RATIOS_PAGES_MEDIA,
        ],
        'pages_media_md' => [
            'title' => 'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:cropVariants.md',
            'selectedRatio' => '16:9',
            'allowedAspectRatios' => self::ALLOWED_ASPECT_RATIOS_PAGES_MEDIA,
        ],
        'pages_media_lg' => [
            'title' => 'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:cropVariants.lg',
            'selectedRatio' => '16:9',
            'allowedAspectRatios' => self::ALLOWED_ASPECT_RATIOS_PAGES_MEDIA,
        ],
        'pages_media_xl' => [
            'title' => 'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:cropVariants.xl',
            'selectedRatio' => '16:9',
            'allowedAspectRatios' => self::ALLOWED_ASPECT_RATIOS_PAGES_MEDIA,
        ],
        'pages_media_xxl' => [
            'title' => 'LLL:EXT:bootstrap/Resources/Private/Language/locallang_db.xlf:cropVariants.xxl',
            'selectedRatio' => '16:9',
            'allowedAspectRatios' => self::ALLOWED_ASPECT_RATIOS_PAGES_MEDIA,
        ],
    ];

    public const CROP_VARIANTS_BOOTSTRAP = [
        'xs',
        'sm',
        'md',
        'lg',
        'xl',
        'xxl',
    ];

    public const CROP_VARIANTS_DEFAULT = [
        'default',
    ];

    public const CROP_VARIANTS_SOCIAL_MEDIA = [
        'social',
    ];

    public const CROP_VARIANTS_PAGES_MEDIA = [
        'pages_media_xs',
        'pages_media_sm',
        'pages_media_md',
        'pages_media_lg',
        'pages_media_xl',
        'pages_media_xxl',
    ];

    /**
     * Filters and returns all cropVariants by the given one (enables only the given one).
     */
    public static function getTcaCropVariantsOverride(array $enabledCropVariants): array
    {
        $cropVariants = [];
        foreach ($enabledCropVariants as $enabledCropVariant) {
            if (array_key_exists($enabledCropVariant, self::CROP_VARIANTS)) {
                $cropVariants[$enabledCropVariant] = self::CROP_VARIANTS[$enabledCropVariant];
            }
        }

        return $cropVariants;
    }
}
