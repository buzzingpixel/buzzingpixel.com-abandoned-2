<?php
declare(strict_types=1);

use src\app\cli\actions\core\RunScheduleAction;

return [
    RunScheduleAction::class => function () {
        return new RunScheduleAction();
    },
];
