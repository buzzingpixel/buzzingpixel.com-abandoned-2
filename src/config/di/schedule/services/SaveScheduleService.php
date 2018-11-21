<?php
declare(strict_types=1);

use src\app\data\factory\AtlasFactory;
use src\app\schedule\services\SaveScheduleService;

return [
    SaveScheduleService::class => function () {
        return new SaveScheduleService(new AtlasFactory());
    },
];
