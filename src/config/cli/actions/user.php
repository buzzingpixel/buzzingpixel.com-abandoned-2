<?php
declare(strict_types=1);

use src\app\cli\actions\user\CreateUserAction;

return [
    'user' => [
        'description' => 'Commands for working with users',
        'commands' => [
            'create' => [
                'description' => 'Creates a user',
                'class' => CreateUserAction::class,
            ],
        ],
    ],
];
