<?php
declare(strict_types=1);

use src\app\http\services\MinifyHtmlService;

return [
    MinifyHtmlService::class => function () {
        return new MinifyHtmlService(
            getenv('ENABLE_HTML_MINIFICATION') === 'true'
        );
    },
];
