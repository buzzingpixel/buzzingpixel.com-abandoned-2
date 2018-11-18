<?php
declare(strict_types=1);

use src\app\cli\actions\core\RunQueueAction;

return [
    RunQueueAction::class => function () {
        return new RunQueueAction();
    },
];
