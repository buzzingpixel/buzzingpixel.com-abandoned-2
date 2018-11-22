<?php
declare(strict_types=1);

use Michelf\SmartyPants;
use src\app\http\twigextensions\UtilitiesTwigExtension;

return [
    UtilitiesTwigExtension::class => function () {
        return new UtilitiesTwigExtension(new SmartyPants());
    },
];
