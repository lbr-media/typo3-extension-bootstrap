<?php

declare(strict_types=1);

namespace LBRmedia\Bootstrap\Listener\TCA\Tables;

use LBRmedia\Bootstrap\Service\TcaService;

interface TablesInterface
{
    public static function process(TcaService $tcaService): void;
}
