<?php
declare(strict_types=1);

use src\app\Di;
use src\app\users\UserApi;

return [
    UserApi::class => function () {
        return new UserApi(new Di());
    },
];
