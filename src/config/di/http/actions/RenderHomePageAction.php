<?php
declare(strict_types=1);

use src\app\Di;
use Twig\Environment;
use Zend\Diactoros\Response;
use src\app\http\actions\RenderHomePageAction;

return [
    RenderHomePageAction::class => function () {
        return new RenderHomePageAction(
            Di::get(Environment::class),
            new Response()
        );
    },
];
