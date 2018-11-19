<?php
declare(strict_types=1);

use src\app\data\factory\AtlasFactory;
use src\app\queue\services\MarkAsStoppedDueToErrorService;

return [
    MarkAsStoppedDueToErrorService::class => function () {
        return new MarkAsStoppedDueToErrorService(
            new AtlasFactory()
        );
    },
];
