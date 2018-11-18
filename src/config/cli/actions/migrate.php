<?php
declare(strict_types=1);

use src\app\cli\actions\migrate\CreateMigrationAction;
use src\app\cli\actions\migrate\MigrationStatusAction;

return [
    'migrate' => [
        'description' => 'Migration commands',
        'commands' => [
            'create' => [
                'description' => 'Creates a migration',
                'class' => CreateMigrationAction::class,
            ],
            'status' => [
                'description' => 'Lists migration status',
                'class' => MigrationStatusAction::class,
            ],
        ],
    ],
];
