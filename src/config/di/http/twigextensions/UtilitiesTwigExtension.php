<?php
declare(strict_types=1);

use src\app\http\twigextensions\UtilitiesTwigExtension;

return [
    UtilitiesTwigExtension::class => function () {
        return new UtilitiesTwigExtension();
    },
];
