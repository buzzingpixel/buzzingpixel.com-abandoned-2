<?php
declare(strict_types=1);

use src\app\Di;
use Twig\Environment;
use Zend\Diactoros\Response;
use src\app\http\services\MinifyHtmlService;
use src\app\content\GetContentFromDirectory;
use src\app\http\actions\RenderHomePageAction;
use src\app\lib\frontmatter\FrontMatterParser;
use src\app\http\services\WriteHtmlToStaticCacheService;

return [
    RenderHomePageAction::class => function () {
        return new RenderHomePageAction(
            Di::get(Environment::class),
            new Response(),
            Di::get(MinifyHtmlService::class),
            Di::get(WriteHtmlToStaticCacheService::class),
            Di::get(GetContentFromDirectory::class)
        );
    },
];
