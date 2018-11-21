<?php
declare(strict_types=1);

use src\app\users\services\SessionGarbageCollectionService;

return [[
    'class' => SessionGarbageCollectionService::class,
    'runEvery' => 'DayAtMidnight',
]];
