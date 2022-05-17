<?php

declare(strict_types=1);

/*
 * @package LBRmedia Bootstrap Template - Provides Twitter Bootstrap 5 and some content elements.
 * @version 1.0.22
 * @author Marcel Briefs <mb@lbrmedia.de>
 * @copyright 2022 LBRmedia
 * @link https://github.com/lbr-media/typo3-extension-bootstrap
 * @license GPL-2.0-or-later
 */

namespace LBRmedia\Bootstrap\Utility;

use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility as CoreGeneralUtility;

class PictureUtility
{
    const CROP_VARIANTS_BOOTSTRAP = [
        'xs',
        'sm',
        'md',
        'lg',
        'xl',
        'xxl',
    ];

    const CROP_VARIANTS_DEFAULT = [
        'default',
    ];

    const CROP_VARIANTS_SOCIAL_MEDIA = [
        'social',
    ];

    const CROP_VARIANTS_PAGES_MEDIA = [
        'pages_media_xs',
        'pages_media_sm',
        'pages_media_md',
        'pages_media_lg',
        'pages_media_xl',
        'pages_media_xxl',
    ];

    /**
     * Returns the value of ext_conf_template.txt:tcaCropVariantsOverridePid.
     */
    public static function getTcaCropVariantsOverridePid(): int
    {
        if (isset($GLOBALS['tx_bootstrap_tcaCropVariantsOverridePid'])) {
            return (int)$GLOBALS['tx_bootstrap_tcaCropVariantsOverridePid'];
        }

        $extConf = CoreGeneralUtility::makeInstance(ExtensionConfiguration::class)->get('bootstrap');
        if (isset($extConf['tcaCropVariantsOverridePid']) && is_numeric($extConf['tcaCropVariantsOverridePid'])) {
            $GLOBALS['tx_bootstrap_tcaCropVariantsOverridePid'] = (int)$extConf['tcaCropVariantsOverridePid'];
        } else {
            $GLOBALS['tx_bootstrap_tcaCropVariantsOverridePid'] = 1;
        }

        return $GLOBALS['tx_bootstrap_tcaCropVariantsOverridePid'];
    }

    /**
     * Filters and returns all cropVariants by the given one (enables only the given one).
     */
    public static function getTcaCropVariantsOverride(array $enabledCropVariants): array
    {
        $pageTsConfig = BackendUtility::getPagesTSconfig(self::getTcaCropVariantsOverridePid());

        $cropVariants = [];
        if (
            isset($pageTsConfig['TCEFORM.']['sys_file_reference.']['crop.']['config.']['cropVariants.']) &&
            is_array($pageTsConfig['TCEFORM.']['sys_file_reference.']['crop.']['config.']['cropVariants.'])
        ) {
            foreach ($pageTsConfig['TCEFORM.']['sys_file_reference.']['crop.']['config.']['cropVariants.'] as $cropVariant => $config) {
                $cropVariant = rtrim($cropVariant, '.');
                $cropVariants[$cropVariant]['disabled'] = in_array($cropVariant, $enabledCropVariants) ? false : true;
            }
        }

        return $cropVariants;
    }
}
