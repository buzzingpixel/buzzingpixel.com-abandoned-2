<?php
declare(strict_types=1);

use src\app\factories\UuidFactory;
use src\app\data\factory\AtlasFactory;
use src\app\queue\services\AddToQueueService;

return [
    AddToQueueService::class => function () {
        return new AddToQueueService(
            new UuidFactory(),
            new AtlasFactory
        );
    },
];
