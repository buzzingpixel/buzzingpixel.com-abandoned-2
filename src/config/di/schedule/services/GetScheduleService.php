<?php
declare(strict_types=1);

use src\app\data\factory\AtlasFactory;
use src\app\schedule\services\GetScheduleService;

return [
    GetScheduleService::class => function () {
        $sep = DIRECTORY_SEPARATOR;
        $schedule = include APP_BASE_PATH . $sep . 'src' . $sep . 'config' . $sep . 'schedule'
            . $sep . '_collector.php';
        return new GetScheduleService(new AtlasFactory(), $schedule);
    },
];
