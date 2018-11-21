<?php
declare(strict_types=1);

use src\app\Di;
use src\app\queue\QueueApi;

return [
    QueueApi::class => function () {
        return new QueueApi(new Di());
    },
];
