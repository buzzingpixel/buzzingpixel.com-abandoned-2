<?php
declare(strict_types=1);

use src\app\Di;
use src\app\queue\QueueApi;
use src\app\cli\actions\core\RunQueueAction;

return [
    RunQueueAction::class => function () {
        return new RunQueueAction(
            new Di(),
            Di::get(QueueApi::class)
        );
    },
];
