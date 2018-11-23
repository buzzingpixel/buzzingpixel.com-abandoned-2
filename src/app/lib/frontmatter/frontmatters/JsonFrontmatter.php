<?php

namespace src\app\lib\frontmatter\frontmatters;

class JsonFrontmatter extends Frontmatter
{
    public const TOKEN = '{';
    public const TOKEN_END = '}';
    public const INCLUDE_TOKEN = true;

    public function parseMeta(): void
    {
        $this->meta = json_decode($this->meta, true);
    }
}
