<?php
declare(strict_types=1);

namespace src\app\factories;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * Class UuidFactory
 */
class UuidFactory
{
    /**
     * Makes an instance of UuidInterface
     * @return UuidInterface
     */
    public function make(): UuidInterface
    {
        return Uuid::uuid4();
    }
}
