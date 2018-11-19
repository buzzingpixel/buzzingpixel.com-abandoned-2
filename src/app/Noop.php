<?php
declare(strict_types=1);

namespace src\app;

/**
 * Class Noop
 */
class Noop
{
    public function __invoke()
    {
        if (getenv('DEV_MODE') === 'true') {
            var_dump('Noop::__invoke()');
        }
    }
}
