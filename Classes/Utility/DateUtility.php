<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Utility;

use DateTime;
use DateTimeInterface;
use DateTimeZone;
use Exception;
use IntlDateFormatter;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\MathUtility;

class DateUtility
{
    /**
     * @param string $timestamp
     * @return DateTime|null
     * @throws Exception
     */
    public static function dateTimeFromTimestamp(string $timestamp): ?DateTime
    {
        if (!trim($timestamp)) {
            return null;
        }

        $base = GeneralUtility::makeInstance(Context::class)->getPropertyFromAspect('date', 'timestamp');
        if (is_string($base)) {
            $base = trim($base);
        }

        if (!MathUtility::canBeInterpretedAsInteger($timestamp)) {
            throw new Exception('"' . $timestamp . '" could not be interpreted as timestamp.', 1646498123);
        }

        $date = null;
        try {
            $base = $base instanceof DateTimeInterface ? (int)$base->format('U') : (int)strtotime((MathUtility::canBeInterpretedAsInteger($base) ? '@' : '') . $base);
            $dateTimestamp = strtotime('@' . $timestamp, $base);
            $date = new DateTime('@' . $dateTimestamp);
            $date->setTimezone(new DateTimeZone(isset($GLOBALS['TYPO3_CONF_VARS']['SYS']['phpTimeZone']) ? $GLOBALS['TYPO3_CONF_VARS']['SYS']['phpTimeZone'] :  date_default_timezone_get()));
        } catch (Exception $exception) {
            throw new Exception('"' . $date . '" could not be parsed by DateTime constructor: ' . $exception->getMessage(), 1646498123);
        }
        
        return $date;
    }

    /**
     * @param DateTime $dt
     * @param int $dateType One of the constants in IntlDateFormatter.
     * @param int $timeType One of the constants in IntlDateFormatter.
     * @return string The localized formatted date.
     */
    public static function toLocale(DateTime $dt, int $dateType, int $timeType): string
    {
        $locale = '';
        if ($GLOBALS['TSFE']->getLanguage()->getLocale()) {
            $locale = $GLOBALS['TSFE']->getLanguage()->getLocale(); // de_DE.UTF-8
        } else if ($GLOBALS['TSFE']->getLanguage()->getHreflang()) {
            $locale = $GLOBALS['TSFE']->getLanguage()->getHreflang(); // de-de
        } else if ($GLOBALS['TSFE']->getLanguage()->getTwoLetterIsoCode()) {
            $locale = $GLOBALS['TSFE']->getLanguage()->getTwoLetterIsoCode(); // de
        }
        $df = new IntlDateFormatter(
            $locale,
            $dateType,
            $timeType,
            isset($GLOBALS['TYPO3_CONF_VARS']['SYS']['phpTimeZone']) ? $GLOBALS['TYPO3_CONF_VARS']['SYS']['phpTimeZone'] :  null, // Europe/Berlin
            IntlDateFormatter::GREGORIAN
        );

        return $df->format($dt);
    }

    public static function getIntlDateFormatterConstant(string $type): ?int
    {
        switch ($type) {
            case "FULL":
                return IntlDateFormatter::FULL;
            case "LONG":
                return IntlDateFormatter::LONG;
            case "MEDIUM":
                return IntlDateFormatter::MEDIUM;
            case "SHORT":
                return IntlDateFormatter::SHORT;
            case "RELATIVE_FULL":
                return IntlDateFormatter::RELATIVE_FULL;
            case "RELATIVE_MEDIUM":
                return IntlDateFormatter::RELATIVE_MEDIUM;
            case "RELATIVE_SHORT":
                return IntlDateFormatter::RELATIVE_SHORT;
            case "NONE":
                return IntlDateFormatter::NONE;
        }

        return null;
    }
}
