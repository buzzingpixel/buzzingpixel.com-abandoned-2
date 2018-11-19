<?php
declare(strict_types=1);

use src\app\Di;
use src\app\cli\actions\core\RunQueueAction;
use src\app\queue\services\GetNextQueueItemService;
use src\app\queue\services\MarkAsStoppedDueToError;

return [
    RunQueueAction::class => function () {
        return new RunQueueAction(
            new Di(),
            Di::get(GetNextQueueItemService::class),
            Di::get(MarkAsStoppedDueToError::class)
        );
    },
];
