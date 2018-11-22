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
            new Twig_Function('getenv', [$this, 'getenv']),
            new Twig_Function('fileTime', [$this, 'fileTime']),
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

    public function getenv(string $which)
    {
        return getenv($which);
    }

    public function fileTime(string $filePath = '', $uniqidFallback = true): string
    {
        if (file_exists($filePath)) {
            return (string) filemtime($filePath);
        }

        $filePath = ltrim($filePath, '/');
        $newPath = APP_BASE_PATH . '/' . $filePath;

        if (file_exists($newPath)) {
            return (string) filemtime($newPath);
        }

        $filePath = ltrim($filePath, '/');
        $newPath = APP_BASE_PATH . '/public/' . $filePath;

        if (file_exists($newPath)) {
            return (string) filemtime($newPath);
        }

        if ($uniqidFallback) {
            return uniqid('', false);
        }

        return '0';
    }
}
