<?php
declare(strict_types=1);

namespace src\app\http\actions;

class RenderHomePageAction extends AbstractRenderStandardPageAction
{
    protected function getContentDirectoryPath(): string
    {
        return APP_BASE_PATH . '/src/content/HomePage';
    }
}
