<?php
declare(strict_types=1);

namespace src\app\queue\exceptions;

use Exception;
use Throwable;

/**
 * Class InvalidActionQueueModel
 */
class InvalidActionQueueModel extends Exception
{
    /**
     * InvalidActionQueueModel constructor
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(
        string $message = 'Invalid action queue model',
        int $code = 500,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
