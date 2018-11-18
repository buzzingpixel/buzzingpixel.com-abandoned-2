<?php
declare(strict_types=1);

use src\app\cli\actions\migrate\MigrationUpAction;
use src\app\cli\actions\migrate\MigrationDownAction;
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
            'up' => [
                'description' => 'Runs migrations that need to run',
                'class' => MigrationUpAction::class,
            ],
            'down' => [
                'description' => 'Rolls back previous migration or to specified target',
                'class' => MigrationDownAction::class,
            ],
        ],
    ],
];
