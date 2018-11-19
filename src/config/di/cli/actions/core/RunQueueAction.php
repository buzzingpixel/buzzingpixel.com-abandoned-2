<?php
declare(strict_types=1);

use src\app\Di;
use src\app\cli\actions\core\RunQueueAction;
use src\app\queue\services\MarkItemAsRunService;
use src\app\queue\services\GetNextQueueItemService;
use src\app\queue\services\MarkAsStoppedDueToErrorService;

return [
    RunQueueAction::class => function () {
        return new RunQueueAction(
            new Di(),
            Di::get(GetNextQueueItemService::class),
            Di::get(MarkAsStoppedDueToErrorService::class),
            Di::get(MarkItemAsRunService::class)
        );
    },
];
