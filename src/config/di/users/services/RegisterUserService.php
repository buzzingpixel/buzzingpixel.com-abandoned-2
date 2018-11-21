<?php
declare(strict_types=1);

use src\app\factories\UuidFactory;
use src\app\data\factory\AtlasFactory;
use src\app\users\services\RegisterUserService;

return [
    RegisterUserService::class => function () {
        return new RegisterUserService(new AtlasFactory(), new UuidFactory());
    },
];
