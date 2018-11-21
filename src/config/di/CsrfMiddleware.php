<?php
declare(strict_types=1);

use Grafikart\Csrf\CsrfMiddleware;

return [
    CsrfMiddleware::class => function () {
        return new CsrfMiddleware($_SESSION, 200);
    }
];
