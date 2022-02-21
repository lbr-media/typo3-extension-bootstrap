<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Listener\TCA\TtContent\NewContentElement;

use LBRmedia\Bootstrap\Service\TcaService;

interface NewContentElementInterface
{
    public static function addPlugin(TcaService $tcaService): void;
}
