<?php
declare(strict_types=1);

use src\app\Di;
use src\app\schedule\ScheduleApi;
use src\app\cli\actions\core\RunScheduleAction;
use Symfony\Component\Console\Output\ConsoleOutput;

return [
    RunScheduleAction::class => function () {
        return new RunScheduleAction(
            new Di,
            Di::get(ScheduleApi::class),
            new ConsoleOutput()
        );
    },
];
