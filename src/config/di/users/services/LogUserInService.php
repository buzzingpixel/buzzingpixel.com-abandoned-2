<?php
declare(strict_types=1);

use src\app\Di;
use src\app\cookies\CookieApi;
use src\app\users\services\SaveUserService;
use src\app\users\services\LogUserInService;
use src\app\users\services\FetchUserService;
use src\app\users\services\CreateUserSessionService;
use src\app\users\services\ValidateUserPasswordService;

return [
    LogUserInService::class => function () {
        return new LogUserInService(
            Di::get(ValidateUserPasswordService::class),
            Di::get(FetchUserService::class),
            Di::get(SaveUserService::class),
            Di::get(CreateUserSessionService::class),
            Di::get(CookieApi::class)
        );
    },
];
