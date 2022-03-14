<?php

declare(strict_types=1);

/*
 * @package LBRmedia Bootstrap Template - Provides Twitter Bootstrap 5 and some content elements.
 * @version 1.0.17
 * @author Marcel Briefs <mb@lbrmedia.de>
 * @copyright 2022 LBRmedia
 * @link https://github.com/lbr-media/typo3-extension-bootstrap
 * @license GPL-2.0-or-later
 */

namespace LBRmedia\Bootstrap\Domain\Model;

use LBRmedia\Bootstrap\Service\FlexFormServiceBootstrapTextMediaGrid;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * This content element simulates bootstrap_textmediagrid.
 * It can be used as child content elements p.e. in accordion and tab.
 */
class ContentElement extends AbstractEntity
{
    /**
     * @var string $header
     */
    public $header = '';

    /**
     * @var string $headerPosition
     */
    public $headerPosition = '';

    /**
     * @var string $headerLayout
     */
    public $headerLayout = '';

    /**
     * @var string $headerLink
     */
    public $headerLink = '';

    /**
     * @var int $date
     */
    public $date = 0;

    /**
     * @var ObjectStorage<FileReference> $assets
     */
    public $assets;

    /**
     * @var string $subheader
     */
    public $subheader = '';

    /**
     * @var string $bodytext
     */
    public $bodytext = '';

    /**
     * @var string $spaceBeforeClass
     */
    public $spaceBeforeClass = '';

    /**
     * @var string $spaceAfterClass
     */
    public $spaceAfterClass = '';

    /**
     * @var string $txBootstrapHeaderLayout
     */
    public $txBootstrapHeaderLayout = '';

    /**
     * @var string $txBootstrapHeaderPredefined
     */
    public $txBootstrapHeaderPredefined = '';

    /**
     * @var string $txBootstrapHeaderColor
     */
    public $txBootstrapHeaderColor = '';
    /**
     * @var string $txBootstrapHeaderAdditionalStyles
     */
    public $txBootstrapHeaderAdditionalStyles = '';

    /**
     * @var string $txBootstrapHeaderIcon
     */
    public $txBootstrapHeaderIcon = '';

    /**
     * @var string $txBootstrapHeaderIconset
     */
    public $txBootstrapHeaderIconset = '';

    /**
     * @var string $txBootstrapFlexform
     */
    public $txBootstrapFlexform = '';

    /**
     * @return ObjectStorage
     */
    public function getFiles(): ObjectStorage
    {
        return $this->assets;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            'uid'=> $this->uid,
            'header' => $this->header,
            'header_position' => $this->headerPosition,
            'header_layout' => $this->headerLayout,
            'header_link' => $this->headerLink,
            'date' => $this->date,
            'subheader' => $this->subheader,
            'bodytext' => $this->bodytext,
            'assets' => $this->assets,
            'space_before_class' => $this->spaceBeforeClass,
            'space_after_class' => $this->spaceAfterClass,
            'tx_bootstrap_header_layout' => $this->txBootstrapHeaderLayout,
            'tx_bootstrap_header_predefined' => $this->txBootstrapHeaderPredefined,
            'tx_bootstrap_header_color' => $this->txBootstrapHeaderColor,
            'tx_bootstrap_header_additional_styles' => $this->txBootstrapHeaderAdditionalStyles,
            'tx_bootstrap_header_icon' => $this->txBootstrapHeaderIcon,
            'tx_bootstrap_header_iconset' => $this->txBootstrapHeaderIconset,
            'tx_bootstrap_flexform' => $this->txBootstrapFlexform,
            'frame_class' => 'child-content-element',
            'CType' => 'child-content-element',
            'tx_bootstrap_additional_styles' => '',
            'tx_bootstrap_inner_frame_class' => '',
            'tx_bootstrap_text_color' => '',
            'tx_bootstrap_background_color' => '',
            'layout' => '',
        ];
    }

    public function getGrid(): array
    {
        /** @var FlexFormServiceBootstrapTextMediaGrid $flexFormService */
        $flexFormService = GeneralUtility::makeInstance(FlexFormServiceBootstrapTextMediaGrid::class);
        return $flexFormService->process($this->txBootstrapFlexform);
    }
}
