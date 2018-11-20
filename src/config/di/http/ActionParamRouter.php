<?php
declare(strict_types=1);

use src\app\Di;
use src\app\http\ActionParamRouter;

return [
    ActionParamRouter::class => function () {
        $sep = DIRECTORY_SEPARATOR;
        $actionConfig = include APP_BASE_PATH . $sep . 'src' . $sep . 'config' . $sep . 'http'
            . $sep . 'actionparams' . $sep . '_collector.php';
        return new ActionParamRouter($actionConfig, new Di());
    },
];
