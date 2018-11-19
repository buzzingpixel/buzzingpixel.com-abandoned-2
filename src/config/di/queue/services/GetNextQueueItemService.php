<?php
declare(strict_types=1);

use src\app\data\factory\AtlasFactory;
use src\app\queue\services\GetNextQueueItemService;

return [
    GetNextQueueItemService::class => function () {
        return new GetNextQueueItemService(
            new AtlasFactory
        );
    },
];
