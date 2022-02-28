<?php

namespace LBRmedia\Bootstrap\Hooks\PageLayoutView;

use TYPO3\CMS\Backend\Preview\StandardContentPreviewRenderer;
use TYPO3\CMS\Backend\View\BackendLayout\Grid\GridColumnItem;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\Database\Query\Restriction\WorkspaceRestriction;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;

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
            case 'bootstrap_textimage':
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
            case 'bootstrap_carousel':
                if ($record['image']) {
                    $out .= $this->linkEditContent($this->getThumbCodeUnlinked($record, 'tt_content', 'image'), $record) . '<br />';
                }
                break;
            case "bootstrap_tabs":
                if ($record['tx_bootstrap_tabulatoritems']) {
                    $table = "tx_bootstrap_domain_model_tabulatoritem";
                    $queryBuilder = $this->getQueryBuilderForTable($table);
                    $queryBuilder->select('uid', 'title', 'active')
                        ->from($table)
                        ->where(
                            $queryBuilder->expr()->eq(
                                'tt_content_uid',
                                $queryBuilder->createNamedParameter($record['uid'], \PDO::PARAM_INT)
                            )
                        )
                        ->orderBy("sorting", "ASC");
                    $statement = $queryBuilder->executeQuery();
                    $list = '<ul>';
                    while ($row = $statement->fetchAssociative()) {
                        $list .= '<li>' . $this->linkEditContent(htmlspecialchars(trim($row['title'] . ($row['active'] ? " (aktiv)" : "")), ENT_QUOTES, 'UTF-8', false), $record) . '</li>';
                    }
                    $list .= '</ul>';
                    $out .= $list;
                } else {
                    $out .= $this->linkEditContent("keine Tabulator-Elemente", $record);
                }
                break;
            case "bootstrap_accordion":
                if ($record['tx_bootstrap_accordionitems']) {
                    $table = "tx_bootstrap_domain_model_accordionitem";
                    $queryBuilder = $this->getQueryBuilderForTable($table);
                    $queryBuilder->select('uid', 'title', 'opened_on_load')
                        ->from($table)
                        ->where(
                            $queryBuilder->expr()->eq(
                                'tt_content_uid',
                                $queryBuilder->createNamedParameter($record['uid'], \PDO::PARAM_INT)
                            )
                        )
                        ->orderBy("sorting", "ASC");
                    $statement = $queryBuilder->executeQuery();
                    $list = '<ul>';
                    while ($row = $statement->fetchAssociative()) {
                        $list .= '<li>' . $this->linkEditContent(htmlspecialchars(trim($row['title'] . ($row['opened_on_load'] ? " (geöffnet)" : " (geschlossen)")), ENT_QUOTES, 'UTF-8', false), $record) . '</li>';
                    }
                    $list .= '</ul>';
                    $out .= $list;
                } else {
                    $out .= $this->linkEditContent("keine Accordion-Elemente", $record);
                }
                break;
            case "bootstrap_cards":
                if ($record['tx_bootstrap_carditems']) {
                    $table = "tx_bootstrap_domain_model_carditem";
                    $queryBuilder = $this->getQueryBuilderForTable($table);
                    $queryBuilder->select('uid', 'header', 'title')
                        ->from($table)
                        ->where(
                            $queryBuilder->expr()->eq(
                                'tt_content_uid',
                                $queryBuilder->createNamedParameter($record['uid'], \PDO::PARAM_INT)
                            )
                        )
                        ->orderBy("sorting", "ASC");
                    $statement = $queryBuilder->executeQuery();
                    $list = '<ul>';
                    while ($row = $statement->fetchAssociative()) {
                        $titles = [];
                        if ($row['header']) {
                            $titles[] = $row['header'];
                        }
                        if ($row['title']) {
                            $titles[] = $row['title'];
                        }
                        $list .= '<li>' . $this->linkEditContent(htmlspecialchars(implode(", ", $titles), ENT_QUOTES, 'UTF-8', false), $record) . '</li>';
                    }
                    $list .= '</ul>';
                    $out .= $list;
                } else {
                    $out .= $this->linkEditContent("keine Card-Elemente", $record);
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

    protected function getQueryBuilderForTable($table): QueryBuilder
    {
        /** @var \TYPO3\CMS\Core\Database\Query\QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable($table);
        $queryBuilder->getRestrictions()->removeAll()
            ->add(GeneralUtility::makeInstance(DeletedRestriction::class))
            ->add(GeneralUtility::makeInstance(WorkspaceRestriction::class, (int)$this->getBackendUser()->workspace));
        return $queryBuilder;
    }
}
