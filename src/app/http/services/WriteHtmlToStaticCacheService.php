<?php
declare(strict_types=1);

namespace src\app\http\services;

use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\Filesystem\Filesystem;

class WriteHtmlToStaticCacheService
{
    private $request;
    private $filesystem;
    private $cacheBasePath;
    private $enableWrite;

    public function __construct(
        ServerRequestInterface $request,
        Filesystem $filesystem,
        string $cacheBasePath,
        bool $enableWrite = true
    ) {
        $this->request = $request;
        $this->filesystem = $filesystem;
        $this->cacheBasePath = $cacheBasePath;
        $this->enableWrite = $enableWrite;
    }

    public function __invoke(string $html): void
    {
        $this->write($html);
    }

    public function write(string $html): string
    {
        if (! $this->enableWrite) {
            return $html;
        }

        $sep = DIRECTORY_SEPARATOR;

        $filePath = implode(
            $sep,
            explode(
                '/',
                ltrim(
                    $this->request->getRequestTarget(),
                    '/'
                )
            )
        );

        $fullFilePath = $this->cacheBasePath;

        if ($filePath) {
            $fullFilePath .= $sep . $filePath;
        }

        $fullFilePath .= $sep . 'index.html';

        $this->filesystem->dumpFile($fullFilePath, $html);

        return $html;
    }
}
