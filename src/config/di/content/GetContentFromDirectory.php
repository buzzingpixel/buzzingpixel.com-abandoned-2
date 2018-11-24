<?php
declare(strict_types=1);

use src\app\Di;
use src\app\content\GetContentFromDirectory;
use src\app\lib\frontmatter\FrontMatterParser;

return [
    GetContentFromDirectory::class => function () {
        return new GetContentFromDirectory(Di::get(FrontMatterParser::class));
    }
];
