<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Utility;

use Exception;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\GeneralUtility as Typo3GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

class GeneralUtility
{
    /**
     * Doktype for news category pages.
     */
    const DOKTYPE_PAGE_SECTION = 20;

    /**
     * Removes space and double css-class-strings from array with css classes.
     */
    public static function cleanCssClassesList(array $cssClassesList): array
    {
        if (0 == count($cssClassesList)) {
            return [];
        }

        $cssClassesStr = implode(' ', $cssClassesList);

        return array_unique(Typo3GeneralUtility::trimExplode(' ', $cssClassesStr, true));
    }

    /**
     * Removes space and double css-class-strings from array with css classes.
     */
    public static function cleanCssClassesString(array $cssClassesList): string
    {
        return implode(' ', self::cleanCssClassesList($cssClassesList));
    }

    /**
     * Saves the form data into a logfile.
     *
     * @throws Exception
     */
    public static function logForm(string $suffix, array $data): void
    {
        $contents = [];
        foreach ($data as $key => $value) {
            $contents[] = $key.'='.$value;
        }

        $fileContents = PHP_EOL.PHP_EOL.'-=-=-=-=-=-=- '.date('Y-m-d H:i:s').' -=-=-=-=-=-=-'.PHP_EOL.implode(PHP_EOL, $contents);

        $filename = Environment::getProjectPath().'/var/log/tx_bootstrap_mail_'.$suffix.'.log';

        try {
            $handle = fopen($filename, 'a');
        } catch (\Exception $e) {
            throw new Exception("Could not open $filename for writing log! ".$e->getMessage(), 1589265756);
        }

        fwrite($handle, $fileContents);
        fclose($handle);
    }

    /**
     * @return ConfigurationManager
     */
    public static function getConfigurationManager()
    {
        return Typo3GeneralUtility::makeInstance(ConfigurationManager::class);
        // return Typo3GeneralUtility::makeInstance(ObjectManager::class)->get(ConfigurationManagerInterface::class);
    }

    /**
     * Returns the TypoScript configuration in path: plugin.tx_bootstrap.settings.form.element as array.
     */
    public static function getFormElementPluginSettings(): array
    {
        $settings = self::getFullTypoScript();

        return isset($settings['plugin.']['tx_bootstrap.']['settings.']['form.']['element.']) ? $settings['plugin.']['tx_bootstrap.']['settings.']['form.']['element.'] : [];
    }

    /**
     * Returns the full TypoScript configuration
     */
    public static function getFullTypoScript(): array
    {
        return self::getConfigurationManager()->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);
    }

    /**
     * @return ContentObjectRenderer
     */
    public static function getContentObjectRenderer()
    {
        return Typo3GeneralUtility::makeInstance(
            ContentObjectRenderer::class,
            $GLOBALS['TSFE'] ?? Typo3GeneralUtility::makeInstance(TypoScriptFrontendController::class, Typo3GeneralUtility::makeInstance(Context::class))
        );
    }
}
