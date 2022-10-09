<?php

declare(strict_types=1);

/*
 * @package LBRmedia Bootstrap Template - Provides Twitter Bootstrap 5 and some content elements.
 * @version 1.0.23
 * @author Marcel Briefs <mb@lbrmedia.de>
 * @copyright 2022 LBRmedia
 * @link https://github.com/lbr-media/typo3-extension-bootstrap
 * @license GPL-2.0-or-later
 */

namespace LBRmedia\Bootstrap\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\VersionNumberUtility;

/**
 * Methods which are called by composer.
 */
class UpdateFileadmin extends Command
{
    // no trailing slashes!
    public const JS_DIR = 'public/fileadmin/bootstrap/assets/js';
    public const CSS_DIR = 'public/fileadmin/bootstrap/assets/css';
    public const BS_ICONS_DIR = 'public/fileadmin/bootstrap/assets/bsicon';

    /**
     * directories to be created after installing this extension with composer.
     */
    public const DIRS = [
        'public/fileadmin',
        'public/fileadmin/bootstrap',
        'public/fileadmin/bootstrap/assets',
        self::JS_DIR,
        self::CSS_DIR,
        self::BS_ICONS_DIR,
        self::BS_ICONS_DIR . DIRECTORY_SEPARATOR . 'fonts',
    ];

    /**
     * files to copy from vendor directory after installing this extension with composer.
     */
    public const FILES = [
        // Twitter Bootstrap
        'vendor/twbs/bootstrap/dist/css/bootstrap.min.css' => self::CSS_DIR,
        'vendor/twbs/bootstrap/dist/css/bootstrap.min.css.map' => self::CSS_DIR,
        'vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js' => self::JS_DIR,
        'vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js.map' => self::JS_DIR,

        // Error Page
        'public/typo3conf/ext/bootstrap/Resources/Public/Stylesheets/Frontend/error-page.css' => self::CSS_DIR,
        'public/typo3conf/ext/bootstrap/Resources/Public/JavaScript/SvgError.js' => self::JS_DIR,

        // Additional CSS
        'public/typo3conf/ext/bootstrap/Resources/Public/Stylesheets/Frontend/ContentElement/bootstrap_alert.css' => self::CSS_DIR,
        'public/typo3conf/ext/bootstrap/Resources/Public/Stylesheets/Frontend/ContentElement/bootstrap_textmediafloat.css' => self::CSS_DIR,
        'public/typo3conf/ext/bootstrap/Resources/Public/Stylesheets/Frontend/ContentElement/bootstrap_markdown.css' => self::CSS_DIR,
        'public/typo3conf/ext/bootstrap/Resources/Public/Stylesheets/Frontend/Elements/figure-copyright.css' => self::CSS_DIR,
        'public/typo3conf/ext/bootstrap/Resources/Public/Stylesheets/Frontend/Elements/iconset.css' => self::CSS_DIR,

        // CKEditor
        'public/typo3conf/ext/bootstrap/Resources/Public/Stylesheets/CKEditor/CKEditor.css' => self::CSS_DIR,

        // Masonry
        'public/typo3conf/ext/bootstrap/Resources/Public/JavaScript/lib/imagesloaded.pkgd.min.js' => self::JS_DIR,
        'public/typo3conf/ext/bootstrap/Resources/Public/JavaScript/lib/masonry.pkgd.min.js' => self::JS_DIR,

        // Bootstrap Icons
        'public/typo3conf/ext/bootstrap/Resources/Public/BootstrapIconsFormField.html' => self::BS_ICONS_DIR,
        'vendor/twbs/bootstrap-icons/font/bootstrap-icons.css' => self::BS_ICONS_DIR,
        'vendor/twbs/bootstrap-icons/font/fonts/bootstrap-icons.woff' => self::BS_ICONS_DIR . DIRECTORY_SEPARATOR . 'fonts',
        'vendor/twbs/bootstrap-icons/font/fonts/bootstrap-icons.woff2' => self::BS_ICONS_DIR . DIRECTORY_SEPARATOR . 'fonts',

        // App
        'public/typo3conf/ext/bootstrap/Resources/Public/JavaScript/App.js' => self::JS_DIR,
        'public/typo3conf/ext/bootstrap/Resources/Public/JavaScript/Polyfills.js' => self::JS_DIR,
        'public/typo3conf/ext/bootstrap/Resources/Public/JavaScript/lib/picturefill.min.js' => self::JS_DIR,
    ];

    private bool $_isTypo3Version12 = false;

    /**
     * Configure the command by defining the name, options and arguments
     */
    protected function configure()
    {
        $this->setHelp('Creates directories:' . LF . implode(LF, self::DIRS) . LF . LF . 'Copies files:' . LF . implode(LF, array_keys(self::FILES)));
    }

    /**
     * Executes the command for showing sys_log entries
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int error code
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title($this->getDescription());

        $this->_isTypo3Version12 = VersionNumberUtility::convertVersionNumberToInteger(VersionNumberUtility::getNumericTypo3Version()) >= 12000000 ? true : false;

        $this->_createDirectories($io);
        $this->_copyFiles($io);

        // debug(VersionNumberUtility::convertVersionNumberToInteger(VersionNumberUtility::getNumericTypo3Version()));

        return Command::SUCCESS;
    }

    /**
     * Creates the directories defined in self::DIRS.
     *
     * @param SymfonyStyle $io
     */
    private function _createDirectories(SymfonyStyle $io): void
    {
        $baseDir = self::getBaseDir();


        foreach (self::DIRS as $dir) {
            if ($this->_isTypo3Version12) {
                $dir = str_replace('public/typo3conf/ext/bootstrap/', 'vendor/lbr-media/typo3-extension-bootstrap/', $dir);
            }

            if (!is_dir($baseDir . DIRECTORY_SEPARATOR . $dir)) {
                $io->writeln("creating directory $dir.");
                mkdir($baseDir . DIRECTORY_SEPARATOR . $dir, 0777, true);
            } else {
                $io->writeln("directory $dir already exists.");
            }
        }
    }

    /**
     * Copies the fields defined in self::FILES.
     * Should be called after self::createDirectories().
     *
     * @param SymfonyStyle $io
     */
    private function _copyFiles(SymfonyStyle $io): void
    {
        $baseDir = self::getBaseDir();
        foreach (self::FILES as $source => $target) {
            if ($this->_isTypo3Version12) {
                $source = str_replace('public/typo3conf/ext/bootstrap/', 'vendor/lbr-media/typo3-extension-bootstrap/', $source);
                $target = str_replace('public/typo3conf/ext/bootstrap/', 'vendor/lbr-media/typo3-extension-bootstrap/', $target);
            }

            $sourceAbs = $baseDir . DIRECTORY_SEPARATOR . $source;
            if (!is_file($sourceAbs)) {
                $io->writeln("<error>cannot copy $source. File does not exist!</error>");
                continue;
            }

            if (!is_readable($sourceAbs)) {
                $io->writeln("<error>cannot copy $source. File is not readable!</error>");
                continue;
            }

            $fileinfo = pathinfo($sourceAbs);
            $filename = $fileinfo['basename'];

            if (copy($sourceAbs, $baseDir . DIRECTORY_SEPARATOR . $target . DIRECTORY_SEPARATOR . $filename)) {
                $io->writeln("copy $source to $target/$filename.");
            } else {
                $io->writeln("<error>cannot copy $source to $target/$filename.</error>");
            }
        }
    }

    /**
     * @return string
     */
    protected static function getBaseDir(): string
    {
        return Environment::getProjectPath();
    }
}
