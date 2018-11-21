<?php
declare(strict_types=1);

use src\app\factories\UuidFactory;
use src\app\data\factory\AtlasFactory;
use src\app\users\services\SaveUserService;

return [
    SaveUserService::class => function () {
        return new SaveUserService(new AtlasFactory(), new UuidFactory());
    },
];
