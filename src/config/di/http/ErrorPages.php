<?php
declare(strict_types=1);

use src\app\Di;
use src\app\http\ErrorPages;
use src\app\http\actions\RenderErrorPageAction;

return [
    ErrorPages::class => function () {
        return new ErrorPages(Di::get(RenderErrorPageAction::class));
    },
];
