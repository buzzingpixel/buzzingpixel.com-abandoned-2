<?php
declare(strict_types=1);

namespace src\app\exceptions;

use Exception;
use Throwable;

/**
 * Class DiBuilderException
 */
class DiBuilderException extends Exception
{
    /**
     * DependencyInjectionBuilderException constructor
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(
        string $message = '',
        int $code = 500,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
