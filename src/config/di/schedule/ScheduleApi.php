<?php
declare(strict_types=1);

use src\app\Di;
use src\app\schedule\ScheduleApi;

return [
    ScheduleApi::class => function () {
        return new ScheduleApi(new Di());
    },
];
