<?php
declare(strict_types=1);

namespace src\app\users\exceptions;

use Exception;
use Throwable;

/**
 * Class PasswordTooShortException
 */
class PasswordTooShortException extends Exception
{
    /**
     * InvalidActionQueueModel constructor
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(
        string $message = 'The specified password is too short',
        int $code = 500,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
