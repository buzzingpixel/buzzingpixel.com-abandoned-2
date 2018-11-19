<?php
declare(strict_types=1);

use src\app\data\factory\AtlasFactory;
use src\app\queue\services\UpdateActionQueueService;

return [
    UpdateActionQueueService::class => function () {
        return new UpdateActionQueueService(
            new AtlasFactory()
        );
    },
];
