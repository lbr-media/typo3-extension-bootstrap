<?php

namespace LBRmedia\Bootstrap\Hooks\PageLayoutView;

use TYPO3\CMS\Backend\Preview\StandardContentPreviewRenderer;
use TYPO3\CMS\Backend\View\BackendLayout\Grid\GridColumnItem;

class ContentPreviewRenderer extends StandardContentPreviewRenderer
{

    /**
     * Render a body for the record
     *
     * @param GridColumnItem $item
     * @return string
     */
    public function renderPageModulePreviewContent(GridColumnItem $item): string
    {
        $record = $item->getRecord();
        $out = "";
        switch ($record["CType"]) {
            case 'bootstrap_type1':
                if ($record['image']) {
                    $out .= $this->linkEditContent($this->getThumbCodeUnlinked($record, 'tt_content', 'image'), $record) . '<br />';
                }
                if ($record['bodytext']) {
                    $out .= $this->linkEditContent($this->renderText($record['bodytext']), $record) . '<br />';
                }
                break;
            case "bootstrap_mediagrid":
                if ($record['assets']) {
                    $out .= $this->linkEditContent($this->getThumbCodeUnlinked($record, 'tt_content', 'assets'), $record) . '<br />';
                }
                break;
            case 'bootstrap_type3':
                if ($record['image']) {
                    $out .= $this->linkEditContent($this->getThumbCodeUnlinked($record, 'tt_content', 'image'), $record) . '<br />';
                }
                break;
            case "bootstrap_type4":
                if ($record['image']) {
                    $out .= $this->linkEditContent($this->getThumbCodeUnlinked($record, 'tt_content', 'image'), $record) . '<br />';
                }
                break;
            case "bootstrap_type5":
                $out .= "<strong>Links:</strong><br />";
                if ($record['tx_bootstrap_image1']) {
                    $out .= $this->linkEditContent($this->getThumbCodeUnlinked($record, 'tt_content', 'tx_bootstrap_image1'), $record) . '<br />';
                }
                if ($record['tx_bootstrap_bodytext1']) {
                    $out .= $this->linkEditContent($this->renderText($record['tx_bootstrap_bodytext1']), $record) . '<br />';
                }
                $out .= "<strong>Rechts:</strong><br />";
                if ($record['tx_bootstrap_image2']) {
                    $out .= $this->linkEditContent($this->getThumbCodeUnlinked($record, 'tt_content', 'tx_bootstrap_image2'), $record) . '<br />';
                }
                if ($record['tx_bootstrap_bodytext2']) {
                    $out .= $this->linkEditContent($this->renderText($record['tx_bootstrap_bodytext2']), $record) . '<br />';
                }
                break;
            case 'bootstrap_type6':
                $out .= $record['tx_bootstrap_teammember'] . " Einträge";
                break;
            case 'bootstrap_twocolumnstext':
                $out .= "<strong>Links:</strong><br />";
                if ($record['tx_bootstrap_bodytext1']) {
                    $out .= $this->linkEditContent($this->renderText($record['tx_bootstrap_bodytext1']), $record) . '<br />';
                }
                $out .= "<strong>Rechts:</strong><br />";
                if ($record['tx_bootstrap_bodytext2']) {
                    $out .= $this->linkEditContent($this->renderText($record['tx_bootstrap_bodytext2']), $record) . '<br />';
                }
                break;
            case 'html':
                if ($record['bodytext']) {
                    $out .= $this->linkEditContent($this->renderText(htmlspecialchars($record['bodytext'])), $record) . '<br />';
                }
                break;
            case 'shortcut':
                if ($record['records']) {
                    $out .= $this->linkEditContent('Inhaltselement-IDs: ' . $this->renderText($record['records']), $record) . '<br />';
                }
                break;
            case 'bullets':
                if ($record['bodytext']) {
                    $out .= $this->linkEditContent($this->renderText(htmlspecialchars($record['bodytext'])), $record) . '<br />';
                }
                break;
            case 'table':
                if ($record['bodytext']) {
                    $out .= $this->linkEditContent($this->renderText(htmlspecialchars($record['bodytext'])), $record) . '<br />';
                }
                break;
            case 'bootstrap_textmediagrid':
                if ($record['assets']) {
                    $out .= $this->linkEditContent($this->getThumbCodeUnlinked($record, 'tt_content', 'assets'), $record) . '<br />';
                }
                if ($record['bodytext']) {
                    $out .= $this->linkEditContent($this->renderText($record['bodytext']), $record) . '<br />';
                }
                break;
            case 'bootstrap_textmediafloat':
                if ($record['assets']) {
                    $out .= $this->linkEditContent($this->getThumbCodeUnlinked($record, 'tt_content', 'assets'), $record) . '<br />';
                }
                if ($record['bodytext']) {
                    $out .= $this->linkEditContent($this->renderText($record['bodytext']), $record) . '<br />';
                }
                break;
            default:
                return parent::renderPageModulePreviewContent($item);
        }

        return $out;
    }

    /**
     * Render a footer for the record
     *
     * @param GridColumnItem $item
     * @return string
     */
    public function renderPageModulePreviewFooter(GridColumnItem $item): string
    {
        $content = '';
        $info = [];
        $record = $item->getRecord();

        // `CType`, `list_type` and `frame_class` are the only differences to the parent class` method: 
        $this->getProcessedValue($item, 'CType,list_type,starttime,endtime,fe_group,frame_class,space_before_class,space_after_class', $info);

        if (!empty($GLOBALS['TCA']['tt_content']['ctrl']['descriptionColumn']) && !empty($record[$GLOBALS['TCA']['tt_content']['ctrl']['descriptionColumn']])) {
            $info[] = htmlspecialchars($record[$GLOBALS['TCA']['tt_content']['ctrl']['descriptionColumn']]);
        }

        if (!empty($info)) {
            $content = implode('<br>', $info);
        }

        if (!empty($content)) {
            $content = '<div class="t3-page-ce-footer">' . $content . '</div>';
        }

        return $content;
    }
}
