<?php
declare(strict_types=1);

use src\app\Di;
use src\app\users\services\SaveUserService;
use src\app\users\services\RegisterUserService;

return [
    RegisterUserService::class => function () {
        return new RegisterUserService(Di::get(SaveUserService::class));
    },
];
