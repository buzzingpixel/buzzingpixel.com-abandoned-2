<?php
declare(strict_types=1);

use src\app\utilities\CaseConversionService;

return [
    CaseConversionService::class => function () {
        return new CaseConversionService();
    }
];
