<?php
declare(strict_types=1);

namespace src\app\data\factory;

use src\app\Di;
use Atlas\Orm\Atlas;

class AtlasFactory
{
    /**
     * Makes an instance of Atlas
     * @return Atlas
     */
    public function make(): Atlas
    {
        return Di::make(Atlas::class);
    }
}
