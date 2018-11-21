<?php
declare(strict_types=1);

use src\app\Noop;

return [[
    'class' => Noop::class,
    'runEvery' => 'Always',
]];
