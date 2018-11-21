<?php
declare(strict_types=1);

use src\app\Di;
use src\app\users\services\SessionGarbageCollectionService;

return [
    SessionGarbageCollectionService::class => function () {
        return new SessionGarbageCollectionService(Di::get('PDO'));
    },
];
