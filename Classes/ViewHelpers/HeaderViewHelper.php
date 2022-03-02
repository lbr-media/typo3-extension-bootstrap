<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\ViewHelpers;

use LBRmedia\Bootstrap\Utility\GeneralUtility as BootstrapGeneralUtility;
use LBRmedia\Bootstrap\Utility\BootstrapUtility;
use TYPO3\CMS\Core\Imaging\ImageManipulation\CropVariantCollection;
use TYPO3\CMS\Core\Resource\FileRepository;
use TYPO3\CMS\Core\Resource\FileReference;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Service\ImageService;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\TagBuilder;

/**
 * Builds main headlines in content elements while using fields header, subheader, header_layout, tx_bootstrap_header_layout, header_position and header_link.
 *
 * Examples
 * ========
 *
 * ::
 *
 *    {bs:Header(data:data)}.
 */
class HeaderViewHelper extends AbstractTagBasedViewHelper
{
    const LINEBREAK_MARKUP = '<br />';

    const REPLACEMENTS = [
        '|' => '&shy;',
        '&vert;' => '&shy;',
        '&bsol;n' => self::LINEBREAK_MARKUP,
        '&NewLine;' => self::LINEBREAK_MARKUP,
        "\n" => '',
    ];

    /**
     * main tag name.
     *
     * @var string
     */
    protected $tagName = 'h1';

    /**
     * @var array
     */
    protected $outerWrap = [
        'before' => [],
        'after' => [],
    ];

    /**
     * @var array
     */
    protected $innerWrap = [
        'before' => [],
        'after' => [],
    ];

    /**
     * @var array
     */
    protected $classesList = [];

    /**
     * Children must not be escaped, to be able to pass {bodytext} directly to it.
     *
     * @var bool
     */
    protected $escapeChildren = false;

    /**
     * The output may contain HTML and can not be escaped.
     *
     * @var bool
     */
    protected $escapeOutput = false;

    /**
     * @var ImageService
     */
    protected $imageService = null;

    /**
     * @var ContentObjectRenderer
     */
    protected $contentObject = null;

    /**
     * @var FileRepository
     */
    protected $fileRepository = null;

    public function injections(
        ImageService $imageService,
        ContentObjectRenderer $contentObject,
        FileRepository $fileRepository
    ): void {
        $this->imageService = $imageService;
        $this->contentObject = $contentObject;
        $this->fileRepository = $fileRepository;
    }

    public function initializeArguments(): void
    {
        $this->registerArgument('contentElementData', 'array', 'data from content element');
        $this->registerArgument('headerSubheaderPattern', 'string', 'Provides placeholder for ###TAG_START###, ###HEADER###, ###SUBHEADER###, ###TAG_END###', false, '###TAG_START######HEADER###<small class="d-block">###SUBHEADER###</small>###TAG_END###');
    }

    public function render(): string
    {
        $data = $this->arguments['contentElementData'];

        // determine visibility and tag name
        if ('100' === $data['header_layout'] || '' === $data['header']) {
            return '';
        } elseif ('0' !== $data['header_layout']) {
            $this->tagName = 'h' . $data['header_layout'];
        }

        $headerSubheaderPattern = $this->arguments['headerSubheaderPattern'];

        // create tag
        $this->tag = new TagBuilder($this->tagName);
        $this->tag->forceClosingTag(true);

        // render the header content
        $header = [
            'before' => '',
            'between' => str_replace(chr(124), '&shy;', nl2br(htmlspecialchars($data['header'], ENT_HTML5, 'UTF-8'))),
            'after' => '',
        ];

        // process subheader
        if (trim($data['subheader'])) {
            // get the parts out of pattern
            $startPos = strpos($headerSubheaderPattern, '###TAG_START###');
            $endPos = strpos($headerSubheaderPattern, '###TAG_END###');
            $pattern = [
                'before' => false !== $startPos && $startPos > 0 ? substr($headerSubheaderPattern, 0, $startPos) : '',
                'between' => substr($headerSubheaderPattern, $startPos + 15, $endPos - $startPos - 15),
                'after' => false !== $endPos && $endPos + $endPos + 13 > mb_strlen($headerSubheaderPattern) ? substr($headerSubheaderPattern, $endPos + 13) : '',
            ];

            $subheader = str_replace(chr(124), '&shy;', nl2br(htmlspecialchars($data['subheader'], ENT_HTML5, 'UTF-8')));

            $header = [
                'before' => str_replace(['###HEADER###', '###SUBHEADER###'], [$header['between'], $subheader], $pattern['before']),
                'between' => str_replace(['###HEADER###', '###SUBHEADER###'], [$header['between'], $subheader], $pattern['between']),
                'after' => str_replace(['###HEADER###', '###SUBHEADER###'], [$header['between'], $subheader], $pattern['after']),
            ];
        }

        // get default classes
        $this->classesList = [
            $data['tx_bootstrap_header_layout'],
            $data['tx_bootstrap_header_color'],
            $data['header_position'],
        ];

        // prepend between with icon
        if ($data['tx_bootstrap_header_icon']) {
            $files = $this->_getFiles('tx_bootstrap_header_icon', $data, true);
            if (isset($files[0]) && $files[0]) {
                $headerIconWrap = new TagBuilder('span');
                $headerIconWrap->addAttribute('class', 'header-icon');

                $headerIconGfx = new TagBuilder('span');
                $headerIconGfx->addAttribute('class', 'header-icon__gfx');
                $headerIconGfx->setContent($this->_renderIcon($files[0]));

                $headerIconText = new TagBuilder('span');
                $headerIconText->addAttribute('class', 'header-icon__text');
                $headerIconText->setContent($header['between']);

                $headerIconWrap->setContent($headerIconGfx->render() . $headerIconText->render());

                $header['between'] = $headerIconWrap->render();
            }
        } else if ($data['tx_bootstrap_header_iconset']) {
            $header['between'] = BootstrapUtility::renderIconSet($data['tx_bootstrap_header_iconset'], $header['between']);
        }

        // get default classes
        $this->classesList = [
            $data['tx_bootstrap_header_layout'],
            $data['tx_bootstrap_header_color'],
            $data['header_position'],
        ];

        // render link
        if ($data['header_link']) {
            $header['between'] = $this->createTypolink($header['between'], $data['header_link']);
        }

        // get the TS setup for further use ...
        $pluginSettings = BootstrapGeneralUtility::getFormElementPluginSettings();

        // ... predefined header
        if ($data['tx_bootstrap_header_predefined']) {
            if (isset($pluginSettings['PredefinedHeader.']) && is_array($pluginSettings['PredefinedHeader.'])) {
                $tsConfigKey = $data['tx_bootstrap_header_predefined'] . '.';
                if (isset($pluginSettings['PredefinedHeader.'][$tsConfigKey])) {
                    $this->prepareAdditionals($pluginSettings['PredefinedHeader.'][$tsConfigKey]);
                }
            }
        }

        // ... additional_styles
        if ($data['tx_bootstrap_header_additional_styles']) {
            $additionalStyles = explode(',', $data['tx_bootstrap_header_additional_styles']);
            if (isset($pluginSettings['AdditionalHeaderStyles.']) && count($additionalStyles)) {
                foreach ($additionalStyles as $key) {
                    $tsConfigKey = $key . '.';
                    if (isset($pluginSettings['AdditionalHeaderStyles.'][$tsConfigKey])) {
                        $this->prepareAdditionals($pluginSettings['AdditionalHeaderStyles.'][$tsConfigKey]);
                    }
                }
            }
        }

        // include innerWrap
        if (count($this->innerWrap['before'])) {
            $header['between'] = implode('', $this->innerWrap['before']) . $header['between'] . implode('', array_reverse($this->innerWrap['after']));
        }

        // build css classes string
        $classesStr = BootstrapGeneralUtility::cleanCssClassesString($this->classesList);
        if ($classesStr) {
            $this->tag->addAttribute('class', $classesStr);
        }

        // render tag
        $this->tag->setContent($header['between']);
        $hTag = $header['before'] . $this->tag->render() . $header['after'];

        // include outerWrap
        if (count($this->outerWrap['before'])) {
            $hTag = implode('', $this->outerWrap['before']) . $hTag . implode('', array_reverse($this->outerWrap['after']));
        }

        // finally return the headline
        return $hTag;
    }

    /**
     * @param string $content
     * @param string $parameter
     */
    protected function createTypolink($content, $parameter): string
    {
        $this->contentObject->start([], '');
        $content = $this->contentObject->stdWrap($content, [
            'typolink.' => [
                'parameter' => $parameter,
            ],
        ]);

        return $content;
    }

    /**
     * prepares predefined and additional styles.
     */
    protected function prepareAdditionals(array $config): void
    {
        if (isset($config['additionalClass']) && $config['additionalClass']) {
            $this->classesList[] = $config['additionalClass'];
        }

        if (isset($config['outerWrap']) && $config['outerWrap']) {
            $wrap = GeneralUtility::trimExplode('|', $config['outerWrap']);
            $this->outerWrap['before'][] = $wrap[0];
            $this->outerWrap['after'][] = $wrap[1];
        }

        if (isset($config['innerWrap']) && $config['innerWrap']) {
            $wrap = GeneralUtility::trimExplode('|', $config['innerWrap']);
            $this->innerWrap['before'][] = $wrap[0];
            $this->innerWrap['after'][] = $wrap[1];
        }
    }

    private function _getFiles(string $field, array $data, bool $onlyFirstFile = false): array
    {
        $files = [];

        if ($data[$field]) {
            $fileObjects = $this->fileRepository->findByRelation('tt_content', $field, $data['uid']);

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

    private function _renderIcon($file): string
    {
        if ($file instanceof \TYPO3\CMS\Extbase\Domain\Model\FileReference) {
            $file = $file->getOriginalResource();
        } elseif (!$file instanceof \TYPO3\CMS\Core\Resource\FileReference) {
            throw new \Exception('The image file must be an instance of \\TYPO3\\CMS\\Extbase\\Domain\\Model\\FileReference or \\TYPO3\\CMS\\Core\\Resource\\FileReference', 1509795323);
        }

        /*
         * Check for SVG image
         */
        if ('svg' === strtolower($file->getProperty('extension'))) {
            $imgTag = new TagBuilder('img');
            $imgTag->forceClosingTag(false);
            $imgTag->addAttribute('src', $file->getPublicUrl());
            $imgTag->addAttribute('alt', $file->getProperty('alternative'));
            $imgTag->addAttribute('title', $file->getProperty('title'));

            return $imgTag->render();
        }

        /*
         * not a SVG
         */
        $processingInstructions = '';
        if ($file->hasProperty('crop') && $file->getProperty('crop')) {
            $cropVariantCollection = CropVariantCollection::create((string) $file->getProperty('crop'));
            $cropArea = $cropVariantCollection->getCropArea('default');
            $processingInstructions = $cropArea->isEmpty() ? null : $cropArea->makeAbsoluteBasedOnFile($this->file);
        }

        // render image
        $processedImage = $this->imageService->applyProcessingInstructions(
            $this->imageService->getImage('', $file, true),
            [
                'maxWidth' => 128,
                'crop' => $processingInstructions,
            ]
        );

        $url = $this->imageService->getImageUri($processedImage);

        if ($url) {
            $imgTag = new TagBuilder('img');
            $imgTag->forceClosingTag(false);
            $imgTag->addAttribute('src', $url);
            $imgTag->addAttribute('alt', $file->getProperty('alternative'));
            $imgTag->addAttribute('title', $file->getProperty('title'));

            return $imgTag->render();
        }

        return '';
    }
}
