<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Domain\Model;

use Exception;
use LBRmedia\Bootstrap\Service\FlexFormServiceBootstrapTextMediaGrid;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * This content element simulates bootstrap_textmediagrid.
 * It can be used as child content elements p.e. in accordion and tab.
 */
class ContentElement extends AbstractEntity
{
    /**
     * @var string
     */
    protected $header = "";

    /**
     * @var string
     */
    protected $headerPosition = "";

    /**
     * @var string
     */
    protected $headerLayout = "";

    /**
     * @var string
     */
    protected $headerLink = "";

    /**
     * @var int
     */
    protected $date = 0;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     */
    protected $assets = null;

    /**
     * @var string
     */
    protected $subheader = "";

    /**
     * @var string
     */
    protected $bodytext = "";

    /**
     * @var string
     */
    protected $spaceBeforeClass = "";

    /**
     * @var string
     */
    protected $spaceAfterClass = "";

    /**
     * @var string
     */
    protected $txBootstrapHeaderLayout = "";

    /**
     * @var string
     */
    protected $txBootstrapHeaderPredefined = "";

    /**
     * @var string
     */
    protected $txBootstrapHeaderColor = "";
    /**
     * @var string
     */
    protected $txBootstrapHeaderAdditionalStyles = "";

    /**
     * @var string
     */
    protected $txBootstrapHeaderIcon = "";

    /**
     * @var string
     */
    protected $txBootstrapFlexform = "";

    public function getFiles():\TYPO3\CMS\Extbase\Persistence\ObjectStorage
    {
        return $this->assets;
    }

    public function getData():array
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
            'tx_bootstrap_flexform' => $this->txBootstrapFlexform,
            'frame_class' => "child-content-element",
            'CType' => "child-content-element",
            'tx_bootstrap_additional_styles' => "",
            'tx_bootstrap_inner_frame_class' => "",
            'tx_bootstrap_text_color' => "",
            'tx_bootstrap_background_color' => "",
            'layout' => "",
        ];
    }

    public function getGrid():array
    {        
        /** @var FlexFormServiceBootstrapTextMediaGrid $flexFormService */
        $flexFormService = GeneralUtility::makeInstance(FlexFormServiceBootstrapTextMediaGrid::class);
        return $flexFormService->process($this->txBootstrapFlexform);
    }
}
