<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Domain\Model;

use Exception;
use LBRmedia\Bootstrap\Service\FlexFormServiceTtContent;
use LBRmedia\Bootstrap\Utility\BootstrapUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Items for the accordion content element
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
        // try {
            // get the configuration from flexform
            /** @var FlexFormServiceTtContent $flexFormService */
            $flexFormService = GeneralUtility::makeInstance(FlexFormServiceTtContent::class);
            $xmlArray = $flexFormService->getConfiguration($this->txBootstrapFlexform, FlexFormServiceTtContent::TYPE_TT_CONTENT_BOOTSTRAP_TEXT_MEDIA_GRID);
        // } catch (Exception $e) {
        //     return $processedData;
        // }

        return self::process_BootstrapTextMediaGrid($xmlArray);
    }

    protected static function process_BootstrapTextMediaGrid($xmlArray): array
    {
        $spaceClasses = BootstrapUtility::getGridSpaceXYClasses($xmlArray['space_x'], $xmlArray['space_y']);
        $xmlArray['row_space_classes'] = $spaceClasses['row'];
        $xmlArray['col_space_classes'] = $spaceClasses['col'];

        $xmlArray['row_classes'] = implode(
            ' ',
            [
                'row',
                BootstrapUtility::getAlignmentClasses($xmlArray['align_items'], 'align-items-'),
                BootstrapUtility::getAlignmentClasses($xmlArray['justify_content'], 'justify-content-'),
            ]
        );

        $xmlArray['col_text_classes'] = BootstrapUtility::getColClasses($xmlArray['col_text']);
        $textAlignSelfClasses = BootstrapUtility::getAlignmentClasses($xmlArray['text']['align_self'], 'align-self-');
        if (trim($textAlignSelfClasses)) {
            $xmlArray['col_text_classes'] .= ' ' . $textAlignSelfClasses;
        }

        $xmlArray['col_media_classes'] = BootstrapUtility::getColClasses($xmlArray['col_media']);
        $mediaAlignSelfClasses = BootstrapUtility::getAlignmentClasses($xmlArray['media']['align_self'], 'align-self-');
        if (trim($mediaAlignSelfClasses)) {
            $xmlArray['col_media_classes'] .= ' ' . $mediaAlignSelfClasses;
        }

        // device_order
        if (isset($xmlArray['device_order']) && 5 === substr_count($xmlArray['device_order'], ';')) {
            $orderClasses = BootstrapUtility::getGridDeviceOrderClasses($xmlArray['device_order']);
            if ($orderClasses['text']) {
                $xmlArray['col_text_classes'] .= ' ' . $orderClasses['text'];
            }
            if ($orderClasses['media']) {
                $xmlArray['col_media_classes'] .= ' ' . $orderClasses['media'];
            }
        }

        // text
        $textItemClasses = [];

        $textPaddingClasses = BootstrapUtility::getPaddingClasses($xmlArray['text']['space_inner']);
        if (trim($textPaddingClasses)) {
            $textItemClasses[] = $textPaddingClasses;
        }

        $xmlArray['text']['item_classes'] = count($textItemClasses) ? implode(' ', $textItemClasses) : '';

        // media
        $mediaItemClasses = [];
        $mediaPaddingClasses = BootstrapUtility::getPaddingClasses($xmlArray['media']['space_inner']);
        if (trim($mediaPaddingClasses)) {
            $mediaItemClasses[] = $mediaPaddingClasses;
        }

        $xmlArray['media']['item_classes'] = count($mediaItemClasses) ? implode(' ', $mediaItemClasses) : '';

        // mediaitem
        $mediaSpaceClasses = BootstrapUtility::getGridSpaceXYClasses($xmlArray['mediaitem']['space_x'], $xmlArray['mediaitem']['space_y']);
        $xmlArray['mediaitem']['row_space_classes'] = $mediaSpaceClasses['row'];
        $xmlArray['mediaitem']['col_space_classes'] = $mediaSpaceClasses['col'];

        // container for all media items
        $xmlArray['mediaitem']['row_classes'] = implode(
            ' ',
            [
                'row',
                BootstrapUtility::getAlignmentClasses($xmlArray['mediaitem']['align_items'], 'align-items-'),
                BootstrapUtility::getAlignmentClasses($xmlArray['mediaitem']['justify_content'], 'justify-content-'),
            ]
        );

        // a media item columne
        $xmlArray['mediaitem']['col_classes'] = BootstrapUtility::getColClasses($xmlArray['mediaitem']['col']);

        // the image
        $xmlArray['mediaitem']['img_classes'] = 'img-fluid';

        return $xmlArray;
    }
}
