<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\ViewHelpers;

use LBRmedia\Bootstrap\Utility\BootstrapUtility;
use LBRmedia\Bootstrap\Utility\DateUtility;
use LBRmedia\Bootstrap\Utility\GeneralUtility as BootstrapGeneralUtility;
use TYPO3\CMS\Core\Imaging\ImageManipulation\CropVariantCollection;
use TYPO3\CMS\Core\Resource\FileReference;
use TYPO3\CMS\Core\Resource\FileRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Service\ImageService;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\TagBuilder;

/**
 * Builds main headlines in content elements while using fields like:
 * - header
 * - subheader
 * - date
 * - header_layout
 * - tx_bootstrap_header_layout
 * - header_position
 * - header_link.
 *
 * Examples
 * ========
 *
 * @code{.html}
 * <bs:Header
 *     contentElementData="{data}"
 *     headerPattern="{settings.bootstrap.header_pattern}"
 *     headerSubheaderPattern="{settings.bootstrap.header_subheader_pattern}"
 *     headerDatePattern="{settings.bootstrap.header_date_pattern}"
 *     headerSubheaderDatePattern="{settings.bootstrap.header_subheader_date_pattern}"
 *     dateDateType="{settings.bootstrap.header_date_datetype}"
 *     dateTimeType="{settings.bootstrap.header_date_timetype}"
 *     />
 * @endcode
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
     * @var string $tagName
     */
    protected $tagName = 'h1';

    /**
     * @var array $outerWrap
     */
    protected $outerWrap = [
        'before' => [],
        'after' => [],
    ];

    /**
     * @var array $innerWrap
     */
    protected $innerWrap = [
        'before' => [],
        'after' => [],
    ];

    /**
     * @var array $classesList
     */
    protected $classesList = [];

    /**
     * Children must not be escaped, to be able to pass {bodytext} directly to it.
     *
     * @var bool $escapeChildren
     */
    protected $escapeChildren = false;

    /**
     * The output may contain HTML and can not be escaped.
     *
     * @var bool $escapeOutput
     */
    protected $escapeOutput = false;

    /**
     * @var ImageService $imageService
     */
    protected $imageService;

    /**
     * @var ContentObjectRenderer $contentObject
     */
    protected $contentObject;

    /**
     * @var FileRepository $fileRepository
     */
    protected $fileRepository;

    /**
     * @param ImageService $imageService
     * @param ContentObjectRenderer $contentObject
     * @param FileRepository $fileRepository
     */
    public function injections(
        ImageService $imageService,
        ContentObjectRenderer $contentObject,
        FileRepository $fileRepository
    ): void {
        $this->imageService = $imageService;
        $this->contentObject = $contentObject;
        $this->fileRepository = $fileRepository;
    }

    /**
     * Arguments for this view helper:
     * - contentElementData
     * - headerPattern
     * - headerSubheaderPattern
     * - headerDatePattern
     * - headerSubheaderDatePattern
     * - dateDateType
     * - dateTimeType
     */
    public function initializeArguments(): void
    {
        $this->registerArgument(
            'contentElementData',
            'array',
            'data from content element'
        );
        $this->registerArgument(
            'headerPattern',
            'string',
            'Provides placeholder for ###TAG_START###, ###HEADER###, ###TAG_END###',
            false,
            '###TAG_START######HEADER######TAG_END###'
        );
        $this->registerArgument(
            'headerSubheaderPattern',
            'string',
            'Provides placeholder for ###TAG_START###, ###HEADER###, ###SUBHEADER###, ###TAG_END###',
            false,
            '###TAG_START######HEADER###<small class="d-block text-muted">###SUBHEADER###</small>###TAG_END###'
        );
        $this->registerArgument(
            'headerDatePattern',
            'string',
            'Provides placeholder for ###TAG_START###, ###HEADER###, ###DATE###, ###DATE_DATETIME###, ###TAG_END###',
            false,
            '<span class="d-block" datetime="###DATE_DATETIME###">###DATE###</span>###TAG_START######HEADER######TAG_END###'
        );
        $this->registerArgument(
            'headerSubheaderDatePattern',
            'string',
            'Provides placeholder for ###TAG_START###, ###HEADER###, ###SUBHEADER###, ###DATE###, ###DATE_DATETIME###, ###TAG_END###',
            false,
            '<span class="d-block" datetime="###DATE_DATETIME###">###DATE###</span>###TAG_START######HEADER###<small class="d-block text-muted">###SUBHEADER###</small>###TAG_END###'
        );
        $this->registerArgument(
            'dateDateType',
            'string',
            'IntlDateFormatter constant name: NONE, FULL, LONG, MEDIUM, SHORT, RELATIVE_FULL, RELATIVE_MEDIUM, RELATIVE_SHORT',
            false,
            'FULL'
        );
        $this->registerArgument(
            'dateTimeType',
            'string',
            'IntlDateFormatter constant name: NONE, FULL, LONG, MEDIUM, SHORT, RELATIVE_FULL, RELATIVE_MEDIUM, RELATIVE_SHORT',
            false,
            'NONE'
        );
    }

    /**
     * Renders the headline.
     *
     * @return string The header html.
     */
    public function render(): string
    {
        $data = $this->arguments['contentElementData'];

        /**
         * determine visibility and tag name
         */
        if ('100' === $data['header_layout'] || '' === $data['header']) {
            return '';
        }
        if ('0' !== $data['header_layout']) {
            $this->tagName = 'h' . $data['header_layout'];
        }

        /**
         * Create tag
         */
        $this->tag = new TagBuilder($this->tagName);
        $this->tag->forceClosingTag(true);

        /**
         * Create contents for placeholders
         */
        // ###HEADER###
        $HEADER = str_replace(chr(124), '&shy;', nl2br(htmlspecialchars($data['header'], ENT_HTML5, 'UTF-8')));

        // Process the link which wraps only the real header
        if ($data['header_link']) {
            $HEADER = $this->createTypolink($HEADER, $data['header_link']);
        }

        // ###SUBHEADER###
        $SUBHEADER = str_replace(chr(124), '&shy;', nl2br(htmlspecialchars($data['subheader'], ENT_HTML5, 'UTF-8')));

        // ###DATE### and ###DATE_DATETIME###
        $DATE = '';
        $DATE_DATETIME = '';
        if ($data['date']) {
            $dateTime = DateUtility::dateTimeFromTimestamp((string)$data['date']);
            if ($dateTime) {
                $DATE = DateUtility::toLocale($dateTime, DateUtility::getIntlDateFormatterConstant($this->arguments['dateDateType']), DateUtility::getIntlDateFormatterConstant($this->arguments['dateTimeType']));
                $DATE_DATETIME = $dateTime->format('Y-m-d');
            }
        }

        /**
         * Render the header parts
         */
        // Determine the used pattern
        $finalPattern = $this->arguments['headerPattern'];
        if ($HEADER && $SUBHEADER && $DATE) {
            $finalPattern = $this->arguments['headerSubheaderDatePattern'];
        } elseif ($HEADER && $SUBHEADER) {
            $finalPattern = $this->arguments['headerSubheaderPattern'];
        } elseif ($HEADER && $DATE) {
            $finalPattern = $this->arguments['headerDatePattern'];
        }

        // on clearing cache the finalPattern is null. This prevents throwing an error:
        if (!$finalPattern) {
            $finalPattern = '###TAG_START######HEADER######TAG_END###';
        }

        // Divide pattern into before, between and after the h-tag.
        $startPos = strpos($finalPattern, '###TAG_START###');
        $endPos = strpos($finalPattern, '###TAG_END###');
        $pattern = [
            'before' => false !== $startPos && $startPos > 0 ? substr($finalPattern, 0, $startPos) : '',
            'between' => substr($finalPattern, $startPos + 15, $endPos - $startPos - 15),
            'after' => false !== $endPos && $endPos + $endPos + 13 > mb_strlen($finalPattern) ? substr($finalPattern, $endPos + 13) : '',
        ];

        // Replace placeholders with the contents.
        $replacements = [
            '###HEADER###' => $HEADER,
            '###SUBHEADER###' => $SUBHEADER,
            '###DATE###' => $DATE,
            '###DATE_DATETIME###' => $DATE_DATETIME,
        ];
        $headerParts = [
            'before' => str_replace(array_keys($replacements), $replacements, $pattern['before']),
            'between' => str_replace(array_keys($replacements), $replacements, $pattern['between']),
            'after' => str_replace(array_keys($replacements), $replacements, $pattern['after']),
        ];

        /**
         * Get the default classes.
         * They may be extended later with the predefined or additionalStyles stuff.
         */
        $this->classesList = [
            $data['tx_bootstrap_header_layout'],
        ];

        /**
         * Get the TS setup for further use ...
         * [1] Process predefined header.
         * [2] Process additional styles.
         */
        $pluginSettings = BootstrapGeneralUtility::getFormElementPluginSettings();

        // [1]
        if ($data['tx_bootstrap_header_predefined']) {
            if (isset($pluginSettings['PredefinedHeader.']) && is_array($pluginSettings['PredefinedHeader.'])) {
                $tsConfigKey = $data['tx_bootstrap_header_predefined'] . '.';
                if (isset($pluginSettings['PredefinedHeader.'][$tsConfigKey])) {
                    $this->prepareAdditionals($pluginSettings['PredefinedHeader.'][$tsConfigKey]);
                }
            }
        }

        // [2]
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

        /**
         * Include processed innerWraps
         */
        if (count($this->innerWrap['before'])) {
            $headerParts['between'] = implode('', $this->innerWrap['before']) . $headerParts['between'] . implode('', array_reverse($this->innerWrap['after']));
        }

        /**
         * Process the icons.
         * The h-tag is the content. The outerWrap is the parent.
         * When there is an icon, the alignment and color class is applied to an outer wrap. Otherwise it is applied to the h-tag
         */
        $iconMarkup = '';
        if ($data['tx_bootstrap_header_icon']) {
            // Process file icon
            $files = $this->_getFiles('tx_bootstrap_header_icon', $data, true);
            if (isset($files[0]) && $files[0]) {
                $headerIconWrap = new TagBuilder('span');
                $headerIconWrap->addAttribute('class', 'header-icon d-inline-flex');

                $headerIconGfx = new TagBuilder('span');
                $headerIconGfx->addAttribute('class', 'header-icon__gfx');
                $headerIconGfx->setContent($this->_renderIcon($files[0]));

                $headerIconText = new TagBuilder('span');
                $headerIconText->addAttribute('class', 'header-icon__text');
                $headerIconText->setContent('###HEADER_CONTENT###');

                $headerIconWrap->setContent($headerIconGfx->render() . $headerIconText->render());

                $iconMarkup = $headerIconWrap->render();
            }
        } elseif ($data['tx_bootstrap_header_iconset']) {
            // Process icon set
            $iconMarkup = BootstrapUtility::renderIconSet($data['tx_bootstrap_header_iconset'], '###HEADER_CONTENT###', ['additionalClass' => 'd-inline-flex']);
        }

        if ($iconMarkup) {
            /**
             * Build css classes string and add to h-tag.
             */
            $classesStr = BootstrapGeneralUtility::cleanCssClassesString($this->classesList);
            if ($classesStr) {
                $this->tag->addAttribute('class', $classesStr);
            }

            /**
             * Render the h-tag.
             */
            $this->tag->setContent($headerParts['between']);
            $hTag = $headerParts['before'] . $this->tag->render() . $headerParts['after'];

            /**
             * create outer wrap
             */
            $iconWrap = new TagBuilder('div');
            $classesStr = BootstrapGeneralUtility::cleanCssClassesString([
                $data['tx_bootstrap_header_color'],
                $data['header_position'],
            ]);
            if ($classesStr) {
                $iconWrap->addAttribute('class', $classesStr);
            }
            $iconWrap->setContent(str_replace('###HEADER_CONTENT###', $hTag, $iconMarkup));
            $hTag = $iconWrap->render();
        } else {
            /**
             * Build css classes string and add to h-tag.
             */
            $this->classesList[] = $data['tx_bootstrap_header_color'];
            $this->classesList[] = $data['header_position'];
            $classesStr = BootstrapGeneralUtility::cleanCssClassesString($this->classesList);
            if ($classesStr) {
                $this->tag->addAttribute('class', $classesStr);
            }

            /**
             * Render the h-tag.
             */
            $this->tag->setContent($headerParts['between']);
            $hTag = $headerParts['before'] . $this->tag->render() . $headerParts['after'];
        }

        /**
         * Include processed outerWraps
         */
        if (count($this->outerWrap['before'])) {
            $hTag = implode('', $this->outerWrap['before']) . $hTag . implode('', array_reverse($this->outerWrap['after']));
        }

        /**
         * Finally return the headline
         */
        return $hTag;
    }

    /**
     * Creates a link by using typolink.parameters.
     *
     * @param string $content
     * @param string $parameter
     * @return string HTML markup
     */
    protected function createTypolink(string $content, string $parameter): string
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
     * Prepares predefined and additional styles.
     * They are defined in TypoScript Setup in plugin.tx_bootstrap.settings.form.element.*
     *
     * @param array $config
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

    /**
     * Helper to get file relations (for the icon)
     *
     * @param string $field
     * @param array $data
     * @param bool $onlyFirstFile
     * @return array
     */
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

    /**
     * Helper function to render a file relation in header.
     *
     * @param FileReference $file
     * @return string
     */
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
         * Not a SVG
         */
        $processingInstructions = '';
        if ($file->hasProperty('crop') && $file->getProperty('crop')) {
            $cropVariantCollection = CropVariantCollection::create((string)$file->getProperty('crop'));
            $cropArea = $cropVariantCollection->getCropArea('default');
            $processingInstructions = $cropArea->isEmpty() ? null : $cropArea->makeAbsoluteBasedOnFile($this->file);
        }

        /**
         * Render image
         */
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
