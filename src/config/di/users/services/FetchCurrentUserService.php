<?php
declare(strict_types=1);

use src\app\Di;
use src\app\cookies\CookieApi;
use src\app\data\factory\AtlasFactory;
use src\app\users\services\FetchUserService;
use src\app\users\services\FetchCurrentUserService;

return [
    FetchCurrentUserService::class => function () {
        return new FetchCurrentUserService(
            new AtlasFactory(),
            Di::get(CookieApi::class),
            Di::get(FetchUserService::class)
        );
    },
];
