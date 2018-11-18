<?php
declare(strict_types=1);

use src\app\cli\actions\atlas\GenerateSkeletonAction;

return [
    'atlas' => [
        'description' => 'Atlas ORM commands',
        'commands' => [
            'generate-skeleton' => [
                'description' => 'Generates the Atlas data skeleton',
                'class' => GenerateSkeletonAction::class,
            ],
        ],
    ],
];
