<?php
declare(strict_types=1);

use src\app\http\actions\RenderHomePageAction;

return [
    RenderHomePageAction::class => function () {
        return new RenderHomePageAction();
    },
];
