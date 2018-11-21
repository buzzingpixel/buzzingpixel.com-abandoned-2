<?php
declare(strict_types=1);

use src\app\Di;
use src\app\cookies\CookieApi;
use src\app\data\factory\AtlasFactory;
use src\app\users\services\LogCurrentUserOutService;

return [
    LogCurrentUserOutService::class => function () {
        return new LogCurrentUserOutService(
            new AtlasFactory(),
            Di::get(CookieApi::class)
        );
    },
];
