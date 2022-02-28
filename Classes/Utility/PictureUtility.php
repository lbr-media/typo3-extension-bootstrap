<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Utility;

use TYPO3\CMS\Core\Utility\GeneralUtility as CoreGeneralUtility;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;

class PictureUtility
{
    /**
     * Returns the value of ext_conf_template.txt:tcaCropVariantsOverridePid.
     */
    public static function getTcaCropVariantsOverridePid(): int
    {
        if (isset($GLOBALS['tx_bootstrap_tcaCropVariantsOverridePid'])) {
            return (int) $GLOBALS['tx_bootstrap_tcaCropVariantsOverridePid'];
        }

        $extConf = CoreGeneralUtility::makeInstance(ExtensionConfiguration::class)->get('bootstrap');
        if (isset($extConf['tcaCropVariantsOverridePid']) && is_numeric($extConf['tcaCropVariantsOverridePid'])) {
            $GLOBALS['tx_bootstrap_tcaCropVariantsOverridePid'] = (int) $extConf['tcaCropVariantsOverridePid'];
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
