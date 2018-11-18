<?php
declare(strict_types=1);

use src\app\cli\actions\core\ActionsAction;
use src\app\cli\actions\core\RunQueueAction;

return [
    'core' => [
        'description' => 'Core application commands',
        'commands' => [
            'actions' => [
                'description' => 'Lists available actions',
                'class' => ActionsAction::class,
            ],
            'run-queue' => [
                'description' => 'Runs the queue (use supervisor to run every second)',
                'class' => RunQueueAction::class,
            ],
        ],
    ],
];
