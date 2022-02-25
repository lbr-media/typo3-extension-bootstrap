<?php

declare(strict_types=1);

// register preview renderer
$GLOBALS['TCA']['tt_content']['ctrl']['previewRenderer'] = \LBRmedia\Bootstrap\Hooks\PageLayoutView\ContentPreviewRenderer::class;
