<?php
declare(strict_types=1);

namespace src\app\users\exceptions;

use Exception;
use Throwable;

/**
 * Class InvalidEmailAddressException
 */
class InvalidEmailAddressException extends Exception
{
    /**
     * InvalidActionQueueModel constructor
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(
        string $message = 'The specified email address is invalid',
        int $code = 500,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
