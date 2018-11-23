<?php

namespace src\app\lib\frontmatter\contracts;

interface Frontmatter
{
    public function __construct($contents);

    public function hasMeta(): bool;

    public function getMeta(): array;

    public function getContents(): string;
}
