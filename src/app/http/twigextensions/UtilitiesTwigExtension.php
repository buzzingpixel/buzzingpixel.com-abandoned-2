<?php
declare(strict_types=1);

namespace src\app\http\twigextensions;

use Twig_Function;
use Twig_Extension;
use src\app\http\exceptions\Http404Exception;
use src\app\http\exceptions\Http500Exception;

class UtilitiesTwigExtension extends Twig_Extension
{
    public function getFunctions(): array
    {
        return [
            new Twig_Function('throwHttpError', [$this, 'throwHttpError']),
        ];
    }

    /**
     * @throws Http404Exception
     * @throws Http500Exception
     */
    public function throwHttpError(int $code = 404, string $msg = ''): void
    {
        if ($code === 404) {
            throw new Http404Exception($msg);
        }

        throw new Http500Exception();
    }
}
