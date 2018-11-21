<?php
declare(strict_types=1);

use src\app\cookies\CookieApi;

return [
    CookieApi::class => function () {
        return new CookieApi($_COOKIE);
    },
];
