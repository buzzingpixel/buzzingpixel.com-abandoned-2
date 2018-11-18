<?php
declare(strict_types=1);

use src\app\cli\actions\core\ActionsAction;

return [
    'core' => [
        'description' => 'Core application commands',
        'commands' => [
            'actions' => [
                'description' => 'Lists available actions',
                'class' => ActionsAction::class,
            ],
        ],
    ],
];
