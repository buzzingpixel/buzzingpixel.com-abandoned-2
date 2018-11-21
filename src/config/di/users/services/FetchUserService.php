<?php
declare(strict_types=1);

use src\app\data\factory\AtlasFactory;
use src\app\users\services\FetchUserService;

return [
    FetchUserService::class => function () {
        return new FetchUserService(new AtlasFactory());
    },
];
