<?php
declare(strict_types=1);

namespace src\app\http\services;

use Minify_HTML;

class MinifyHtmlService
{
    private $enableMinification;

    public function __construct($enableMinification = true)
    {
        $this->enableMinification = $enableMinification;
    }

    public function __invoke(string $html, array $options = []): string
    {
        return $this->minifyHtml($html, $options);
    }

    public function minifyHtml(string $html, array $options = []): string
    {
        if (! $this->enableMinification) {
            return $html;
        }

        return (new Minify_HTML($html, $options))->process();
    }
}
