<?php
declare(strict_types=1);

use cebe\markdown\Markdown;
use src\app\lib\frontmatter\FrontMatterParser;

return [
    FrontMatterParser::class => function () {
        return new FrontMatterParser(new Markdown());
    },
];
