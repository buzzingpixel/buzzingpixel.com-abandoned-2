<?php
declare(strict_types=1);

use src\app\Di;
use src\app\factories\UuidFactory;
use src\app\data\factory\AtlasFactory;
use src\app\users\services\FetchUserService;
use src\app\users\services\CreateUserSessionService;

return [
    CreateUserSessionService::class => function () {
        return new CreateUserSessionService(
            new UuidFactory(),
            new AtlasFactory(),
            Di::get(FetchUserService::class)
        );
    },
];
