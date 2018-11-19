<?php
declare(strict_types=1);

use src\app\data\factory\AtlasFactory;
use src\app\queue\services\MarkAsStoppedDueToError;

return [
    MarkAsStoppedDueToError::class => function () {
        return new MarkAsStoppedDueToError(
            new AtlasFactory()
        );
    },
];
