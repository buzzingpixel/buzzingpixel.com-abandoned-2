<?php
declare(strict_types=1);

use src\app\cli\actions\migrate\CreateMigrationAction;

return [
    'migrate' => [
        'description' => 'Migration commands',
        'commands' => [
            'create' => [
                'description' => 'Creates a migration',
                'class' => CreateMigrationAction::class,
            ],
        ],
    ],
];
