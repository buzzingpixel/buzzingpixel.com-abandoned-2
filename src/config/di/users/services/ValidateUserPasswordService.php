<?php
declare(strict_types=1);

use src\app\Di;
use src\app\users\services\FetchUserService;
use src\app\users\services\ValidateUserPasswordService;

return [
    ValidateUserPasswordService::class => function () {
        return new ValidateUserPasswordService(
            Di::get(FetchUserService::class)
        );
    },
];
