<?php

namespace src\app\lib\frontmatter\frontmatters;

class JsonFrontmatter extends Frontmatter
{
    public const TOKEN = '{';
    public const TOKEN_END = '}';
    public const INCLUDE_TOKEN = true;

    public function parseMeta(): void
    {
        if (! $this->meta) {
            return;
        }

        $data = json_decode($this->meta, true);

        $jsonLastErrorCode = json_last_error();

        if ($data === null && $jsonLastErrorCode !== JSON_ERROR_NONE) {
            throw new \Exception(
                'JSON data is improperly formatted. Json error code: ' .
                    $jsonLastErrorCode
            );
        }

        $this->meta = json_decode($this->meta, true);
    }
}
