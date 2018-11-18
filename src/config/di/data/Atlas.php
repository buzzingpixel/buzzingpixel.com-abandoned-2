<?php
declare(strict_types=1);

use Atlas\Orm\Atlas;

return [
    Atlas::class => function () {
        return Atlas::new(
            'mysql:host=' . getenv('DB_HOST') . ';dbname=' .
                getenv('DB_DATABASE'),
            getenv('DB_USER'),
            getenv('DB_PASSWORD')
        );
    }
];
