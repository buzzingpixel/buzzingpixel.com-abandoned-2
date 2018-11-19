<?php
declare(strict_types=1);

use src\app\Di;
use src\app\data\factory\AtlasFactory;
use src\app\queue\services\MarkItemAsRunService;
use src\app\queue\services\UpdateActionQueueService;

return [
    MarkItemAsRunService::class => function () {
        return new MarkItemAsRunService(
            new AtlasFactory(),
            Di::get(UpdateActionQueueService::class)
        );
    },
];
