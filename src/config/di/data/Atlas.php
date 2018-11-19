<?php
declare(strict_types=1);

use src\app\Di;
use Atlas\Orm\Atlas;

return [
    Atlas::class => function () {
        return Atlas::new(Di::get('PDO'));
    },
];
