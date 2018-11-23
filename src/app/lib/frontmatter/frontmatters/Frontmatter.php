<?php

namespace src\app\lib\frontmatter\frontmatters;

use src\app\lib\frontmatter\contracts\Frontmatter as Contract;

abstract class Frontmatter implements Contract
{
    public const TOKEN = null;
    public const TOKEN_END = null;
    public const INCLUDE_TOKEN = false;

    /** @var array|bool */
    protected $meta;

    /** @var string */
    protected $contents;

    public function __construct($contents)
    {
        $this->contents = (string) $contents;

        if (static::TOKEN) {
            $this->getRawTokenMeta();
        }

        $this->parseMeta();
    }

    public function getMeta(): array
    {
        return \is_array($this->meta) ? $this->meta : [];
    }

    public function hasMeta(): bool
    {
        return $this->meta !== false;
    }

    abstract public function parseMeta();

    public function getContents(): string
    {
        return $this->contents;
    }

    protected function getRawTokenMeta(): void
    {
        $this->meta = false;

        $rawMeta = array();

        $contents = explode("\n", $this->contents);

        $tokenStart = static::TOKEN;
        $tokenEnd = static::TOKEN_END ? static::TOKEN_END : static::TOKEN;

        foreach ($contents as $i => $line) {
            if ($i === 0 && strncmp($line, $tokenStart, \strlen($tokenStart)) !== 0) {
                return;
            }

            $rawMeta[] = $line;
            unset($contents[$i]);

            if ($i > 0 && strncmp($line, $tokenEnd, \strlen($tokenEnd)) === 0) {
                break;
            }
        }

        if (!static::INCLUDE_TOKEN) {
            array_pop($rawMeta);
            array_shift($rawMeta);
        }

        $this->contents = implode("\n", $contents);

        $this->meta = implode("\n", $rawMeta);
    }
}
