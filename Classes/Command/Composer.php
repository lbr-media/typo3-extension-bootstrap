<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Command;

use Composer\Script\Event;

/**
 * Methods which are called by composer.
 */
class Composer
{
    // no trailing slashes!
    const JS_DIR = "public/fileadmin/bootstrap/assets/js";
    const CSS_DIR = "public/fileadmin/bootstrap/assets/css";

    /**
     * directories to be created after installing this extension with composer.
     */
    const DIRS = [
        "public/fileadmin",
        "public/fileadmin/bootstrap",
        "public/fileadmin/bootstrap/assets",
        self::JS_DIR,
        self::CSS_DIR
    ];

    /**
     * files to copy from vendor directory after installing this extension with composer.
     */
    const FILES = [
        "vendor/components/jquery/jquery.min.js" => self::JS_DIR,
        "vendor/components/jquery/jquery.min.map" => self::JS_DIR,
        "vendor/twbs/bootstrap/dist/css/bootstrap.min.css" => self::CSS_DIR,
        "vendor/twbs/bootstrap/dist/css/bootstrap.min.css.map" => self::CSS_DIR,
        "vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js" => self::JS_DIR,
        "vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js.map" => self::JS_DIR,
        "public/typo3conf/ext/bootstrap/Resources/Public/Stylesheets/Frontend/bootstrap_textmediafloat.css" => self::CSS_DIR,
        "public/typo3conf/ext/bootstrap/Resources/Public/Stylesheets/Frontend/figure-copyright.css" => self::CSS_DIR,
        "public/typo3conf/ext/bootstrap/Resources/Public/JavaScript/masonry.pkgd.min.js" => self::JS_DIR,
    ];

    /**
     * Will be executed after `composer install` when a composer.lock file already exists.
     */
    public static function postUpdateCmd(Event $event): void
    {
        self::createDirectories($event);
        self::copyFiles($event);
    }

    /**
     * Will be executed after `composer update` when a composer.lock file already exists.
     */
    public static function postInstallCmd(Event $event): void
    {
        self::createDirectories($event);
        self::copyFiles($event);
    }

    protected static function getBaseDir(Event $event): string
    {
        return dirname($event->getComposer()->getConfig()->get('vendor-dir'));
    }

    protected static function createDirectories(Event $event): void
    {
        $baseDir = self::getBaseDir($event);
        foreach (self::DIRS as $dir) {
            if (!is_dir($baseDir . DIRECTORY_SEPARATOR . $dir)) {
                echo "creating directory $dir." . PHP_EOL;
                mkdir($baseDir . DIRECTORY_SEPARATOR . $dir, 0777, true);
            } else {
                echo "directory $dir already exists." . PHP_EOL;
            }
        }
    }

    protected static function copyFiles(Event $event): void
    {
        $baseDir = self::getBaseDir($event);
        foreach (self::FILES as $source => $target) {
            $sourceAbs = $baseDir . DIRECTORY_SEPARATOR . $source;
            if (!is_file($sourceAbs)) {
                echo "ERROR: cannot copy $source. File does not exist!" . PHP_EOL;
                continue;
            }

            if (!is_readable($sourceAbs)) {
                echo "ERROR: cannot copy $source. File is not readable!" . PHP_EOL;
                continue;
            }

            $fileinfo = pathinfo($sourceAbs);
            $filename = $fileinfo["basename"];

            if (copy($sourceAbs, $baseDir . DIRECTORY_SEPARATOR . $target . DIRECTORY_SEPARATOR . $filename)) {
                echo "copy $source to $target$filename." . PHP_EOL;
            } else {
                echo "ERROR: cannot copy $source to $target$filename." . PHP_EOL;
            }
        }
    }
}
