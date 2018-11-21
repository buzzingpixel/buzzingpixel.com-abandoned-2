<?php
declare(strict_types=1);

use src\app\cli\actions\core\ActionsAction;
use src\app\cli\actions\core\RunQueueAction;
use src\app\cli\actions\core\RunScheduleAction;

return [
    'core' => [
        'description' => 'Core application commands',
        'commands' => [
            'actions' => [
                'description' => 'Lists available actions',
                'class' => ActionsAction::class,
            ],
            'run-queue' => [
                'description' => 'Runs queue (use supervisor while loop script to run every second)',
                'class' => RunQueueAction::class,
            ],
            'run-schedule' => [
                'description' => 'Runs schedule (run on cron every minute)',
                'class' => RunScheduleAction::class,
            ],
        ],
    ],
];
