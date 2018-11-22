<?php
declare(strict_types=1);

use src\app\Di;
use Twig\Environment;
use Zend\Diactoros\Response;
use src\app\http\services\MinifyHtmlService;
use src\app\http\actions\RenderErrorPageAction;

return [
    RenderErrorPageAction::class => function () {
        return new RenderErrorPageAction(
            Di::get(Environment::class),
            new Response(),
            Di::get(MinifyHtmlService::class)
        );
    },
];
