<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\DataProcessing;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

// use LBRmedia\Bootstrap\Domain\Repository\ExtendedLinkListItemRepository;
// use LBRmedia\Bootstrap\Domain\Repository\FaqRepository;
// use LBRmedia\Bootstrap\Domain\Repository\LinkListItemRepository;
// use LBRmedia\Bootstrap\Domain\Repository\PodcastRepository;
use TYPO3\CMS\Core\Resource\FileReference;
use TYPO3\CMS\Core\Resource\FileRepository;
use TYPO3\CMS\Core\Service\FlexFormService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\MathUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;
use LBRmedia\Bootstrap\Domain\Repository\TeamMemberRepository;

/**
 * Class for data processing for various content elements which use the extra fields defined in this extension.
 */
class VariousProcessor implements DataProcessorInterface
{
    /**
     * The properties to set for the specific content element.
     *
     * @var array
     */
    protected $properties = [];

    /**
     * holds the flexform data.
     *
     * @var array
     */
    private $_flexformData = [];

    /**
     * @var FileRepository
     */
    protected $fileRepository = null;

    /**
     * @var TeamMemberRepository
     */
    protected $teamMemberRepository = null;

    public function __construct(
        FileRepository $fileRepository,
        TeamMemberRepository $teamMemberRepository
    ) {
        $this->fileRepository = $fileRepository;
        $this->teamMemberRepository = $teamMemberRepository;
    }

    /**
     * Process data for the content element "My new content element".
     *
     * @param ContentObjectRenderer $cObj                       The data of the content element or page
     * @param array                 $contentObjectConfiguration The configuration of Content Object
     * @param array                 $processorConfiguration     The configuration of this processor
     * @param array                 $processedData              Key/value store of processed data (e.g. to be passed to a Fluid View)
     *
     * @return array the processed data as key/value store
     */
    public function process(
        ContentObjectRenderer $cObj,
        array $contentObjectConfiguration,
        array $processorConfiguration,
        array $processedData
    ): array {
        // reset
        $this->_flexformData = [];
        $this->_initProperties($processedData);

        foreach ($this->properties as $property) {
            switch ($property->type) {
                case 'data':
                    $processedData[$property->property] = $this->_hasValue($processedData['data'][$property->field], $property->propertyType) ? $processedData['data'][$property->field] : $property->defaultValue;
                    break;
                case 'database':
                    if ('team_member_uids' === $property->field) {
                        $processedData[$property->property] = [];
                        $uidsString = $this->_getFlexformValue($property->field, $cObj, $processedData);
                        if ($uidsString) {
                            $uids = GeneralUtility::intExplode(',', $uidsString, true);
                            if (count($uids)) {
                                foreach ($uids as $uid) {
                                    $teamMember = $this->teamMemberRepository->findByUid($uid);

                                    if ($teamMember) {
                                        $processedData[$property->property][] = $teamMember;
                                    }
                                }
                            }
                        }
                    }
                    break;
                case 'flexform':
                    $value = $this->_getFlexformValue($property->field, $cObj);
                    $processedData[$property->property] = $this->_hasValue($value, $property->propertyType) ? $value : $property->defaultValue;
                    break;
                case 'files':
                    $files = $this->_getFiles($property->field, $processedData, false);
                    $processedData[$property->property] = count($files) ? $files : $property->defaultValue;
                    break;
                case 'file':
                    $files = $this->_getFiles($property->field, $processedData, true);
                    $processedData[$property->property] = count($files) ? $files[0] : $property->defaultValue;
                    break;
                case 'extbase':
                    $items = $this->_getExtbase($property->field, $processedData, $property->settings);
                    $processedData[$property->property] = count($items) ? $items : $property->defaultValue;
                    break;
            }
        }

        return $processedData;
    }

    private function _initProperties($processedData): void
    {
        switch ($processedData['data']['CType']) {
            case 'bootstrap_type1':
                $this->properties = [
                    new VariousProperty('bodytext', 'data', 'bodytext', '', 'string'),
                    new VariousProperty('image', 'file', 'image', null, 'object'),
                ];
                break;
            case 'bootstrap_type2':
                $this->properties = [
                    new VariousProperty('images', 'files', 'image', [], 'array'),
                ];
                break;
            case 'bootstrap_type3':
                $this->properties = [
                    new VariousProperty('images', 'files', 'image', [], 'array'),
                    new VariousProperty('link1_text', 'flexform', 'link1_text', '', 'string'),
                    new VariousProperty('link1', 'flexform', 'link1', '', 'string'),
                    new VariousProperty('link1_type', 'flexform', 'link1_type', 'btn btn-white', 'string'),
                    new VariousProperty('link2_text', 'flexform', 'link2_text', '', 'string'),
                    new VariousProperty('link2', 'flexform', 'link2', '', 'string'),
                    new VariousProperty('link2_type', 'flexform', 'link2_type', 'btn btn-white', 'string'),
                ];
                break;
            case 'bootstrap_type4':
                $this->properties = [
                    new VariousProperty('images', 'files', 'image', [], 'array'),
                    new VariousProperty('layout', 'flexform', 'layout', 'first_image_left', 'string'),
                ];
                break;
            case 'bootstrap_type5':
                $this->properties = [
                    new VariousProperty('image1', 'file', 'tx_bootstrap_image1', null, 'object'),
                    new VariousProperty('bodytext1', 'data', 'tx_bootstrap_bodytext1', '', 'string'),
                    new VariousProperty('image2', 'file', 'tx_bootstrap_image2', null, 'object'),
                    new VariousProperty('bodytext2', 'data', 'tx_bootstrap_bodytext2', '', 'string'),
                ];
                break;
            case 'bootstrap_type6':
                $this->properties = [
                    new VariousProperty('teamMembers', 'extbase', 'tt_content_uid', [], 'array', [
                        'extbaseType' => 'TeamMember',
                    ]),
                ];
                break;
            case 'bootstrap_type7':
                $this->properties = [
                    new VariousProperty('bodytext1', 'data', 'tx_bootstrap_bodytext1', '', 'string'),
                    new VariousProperty('bodytext2', 'data', 'tx_bootstrap_bodytext2', '', 'string'),
                ];
                break;
        }
    }

    private function _getFlexformValue(string $field, ContentObjectRenderer $cObj): ?string
    {
        if (!count($this->_flexformData) && $cObj->data['tx_bootstrap_flexform']) {
            // parse flexform
            $flexformService = GeneralUtility::makeInstance(FlexFormService::class);
            $this->_flexformData = $flexformService->convertFlexFormContentToArray($cObj->data['tx_bootstrap_flexform']);
        }

        if (isset($this->_flexformData[$field])) {
            return $this->_flexformData[$field];
        }

        return null;
    }

    private function _getFiles(string $field, array $processedData, bool $onlyFirstFile = false): array
    {
        $files = [];

        if ($processedData['data'][$field]) {
            $fileObjects = $this->fileRepository->findByRelation('tt_content', $field, $processedData['data']['uid']);

            foreach ($fileObjects as $fileObject) {
                /** @var FileReference $fileObject */
                if (!$fileObject->isMissing()) {
                    $files[] = $fileObject;
                    if ($onlyFirstFile) {
                        return $files;
                    }
                }
            }
        }

        return $files;
    }

    private function _hasValue($value, string $type): bool
    {
        switch ($type) {
            case 'string':
                return $value ? true : false;
                break;
            case 'int':
                return MathUtility::canBeInterpretedAsInteger($value);
                break;
            case 'float':
                return MathUtility::canBeInterpretedAsFloat($value);
                break;
            case 'bool':
                return in_array($value, ['0', '1', 'true', 'false']) ? true : false;
                break;
            case 'object':
                return is_object($value);
                break;
            case 'array':
                return is_array($value);
                break;
        }
    }

    private function _getExtbase(string $field, array $processedData, array $settings): array
    {
        $items = [];
        switch ($settings['extbaseType']) {
            case 'TeamMember':
                $objects = $this->teamMemberRepository->findByRelation($field, $processedData['data']['uid']);
                $items = $objects->toArray();
                break;
        }

        return $items;
    }
}
