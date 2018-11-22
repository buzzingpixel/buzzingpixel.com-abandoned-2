<?php
declare(strict_types=1);

use Zend\Diactoros\ServerRequestFactory;
use Symfony\Component\Filesystem\Filesystem;
use src\app\http\services\WriteHtmlToStaticCacheService;

return [
    WriteHtmlToStaticCacheService::class => function () {
        $sep = DIRECTORY_SEPARATOR;
        return new WriteHtmlToStaticCacheService(
            ServerRequestFactory::fromGlobals(),
            new Filesystem(),
            APP_BASE_PATH . $sep . 'public' . $sep . 'cache',
            getenv('ENABLE_STATIC_CACHE_WRITING') === 'true'
        );
    },
];
