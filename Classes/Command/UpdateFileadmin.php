<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Command;

use Symfony\Component\Console\Command\Command;
// use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use TYPO3\CMS\Core\Core\Environment;

/**
 * Methods which are called by composer.
 */
class UpdateFileadmin extends Command
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
        // "public/typo3conf/ext/bootstrap/Resources/Public/Stylesheets/Frontend/bootstrap_textmediafloat.css" => self::CSS_DIR,
        // "public/typo3conf/ext/bootstrap/Resources/Public/Stylesheets/Frontend/figure-copyright.css" => self::CSS_DIR,
        "public/typo3conf/ext/bootstrap/Resources/Public/Stylesheets/CKEditor/CKEditor.css" => self::CSS_DIR,
        "public/typo3conf/ext/bootstrap/Resources/Public/JavaScript/masonry.pkgd.min.js" => self::JS_DIR,
    ];

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
     * @return int error code
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title($this->getDescription());

        self::createDirectories($io);
        self::copyFiles($io);

        return Command::SUCCESS;
    }

    protected static function createDirectories(SymfonyStyle $io): void
    {
        $baseDir = self::getBaseDir();
        foreach (self::DIRS as $dir) {
            if (!is_dir($baseDir . DIRECTORY_SEPARATOR . $dir)) {
                $io->writeln("creating directory $dir.");
                mkdir($baseDir . DIRECTORY_SEPARATOR . $dir, 0777, true);
            } else {
                $io->writeln("directory $dir already exists.");
            }
        }
    }

    protected static function copyFiles(SymfonyStyle $io): void
    {
        $baseDir = self::getBaseDir();
        foreach (self::FILES as $source => $target) {
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
            $filename = $fileinfo["basename"];

            if (copy($sourceAbs, $baseDir . DIRECTORY_SEPARATOR . $target . DIRECTORY_SEPARATOR . $filename)) {
                $io->writeln("copy $source to $target$filename.");
            } else {
                $io->writeln("<error>cannot copy $source to $target$filename.</error>");
            }
        }
    }

    protected static function getBaseDir(): string
    {
        return Environment::getProjectPath();
    }
}
