<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Service;

use LBRmedia\Bootstrap\Utility\BootstrapUtility;
use LBRmedia\Bootstrap\Utility\GeneralUtility as BootstrapGeneralUtility;
use TYPO3\CMS\Core\TypoScript\TypoScriptService;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Flexform configurations for content element bootstrap_textimage.
 */
class FlexFormServiceBootstrapTextImage extends FlexFormService implements FlexFormServiceInterface
{
    public function getConfiguration(string $xmlString): array
    {
        $this->initData($xmlString, self::TYPE_TT_CONTENT_BOOTSTRAP_TEXTIMAGE);

        return $this->getConfigurationArray($this->data[self::TYPE_TT_CONTENT_BOOTSTRAP_TEXTIMAGE]);
    }

    public function process(string $xmlString): array
    {
        $xmlArray = $this->getConfiguration($xmlString);
        
        $xmlArray['space_classes'] = BootstrapUtility::getGridSpaceClasses($xmlArray['space']);

        return $xmlArray;
    }

    protected function getConfigurationArray(array $data): array
    {
        $transformedData = [
            'order' => self::getFlexformValueByPath($data, 'data.sGENERAL.lDEF.order.vDEF', 'string', 'text_image', $this->logger),
            'text_align' => self::getFlexformValueByPath($data, 'data.sGENERAL.lDEF.text_align.vDEF', 'string', 'start', $this->logger),
            'image_align' => self::getFlexformValueByPath($data, 'data.sGENERAL.lDEF.image_align.vDEF', 'string', 'start', $this->logger),
            'header_position' => self::getFlexformValueByPath($data, 'data.sGENERAL.lDEF.header_position.vDEF', 'string', 'above_all', $this->logger),
            'space' => self::getFlexformValueByPath($data, 'data.sGENERAL.lDEF.space.vDEF', 'string', ';;;;;', $this->logger),
        ];

        /**
         * Process presets which overrides some/all settings
         */
        $presets = self::getFlexformValueByPath($data, 'data.sGENERAL.lDEF.presets.vDEF', 'string', '', $this->logger);
        if ($presets) {
            $ts = BootstrapGeneralUtility::getFullTypoScript();
            if (isset($ts['tt_content.']['bootstrap_textimage.']['flexform_presets.']) && is_array($ts['tt_content.']['bootstrap_textimage.']['flexform_presets.'])) {
                /** @var TypoScriptService $typoScriptService */
                $typoScriptService = GeneralUtility::makeInstance(TypoScriptService::class);
                $plainTS = $typoScriptService->convertTypoScriptArrayToPlainArray($ts['tt_content.']['bootstrap_textimage.']['flexform_presets.']);

                $keys = GeneralUtility::trimExplode(",", $presets, true);
                foreach ($keys as $key) {
                    $ts = BootstrapGeneralUtility::getFullTypoScript();
                    if (isset($plainTS[$key]['configuration']) && is_array($plainTS[$key]['configuration'])) {
                        ArrayUtility::mergeRecursiveWithOverrule($transformedData, $plainTS[$key]['configuration'], false, true, true);
                    }
                }
            }
        }

        return $transformedData;
    }
}
