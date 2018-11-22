<?php
declare(strict_types=1);

namespace src\app\http\exceptions;

use Exception;
use Throwable;

class Http404Exception extends Exception
{
    public function __construct(
        int $code = 500,
        string $message = '',
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
