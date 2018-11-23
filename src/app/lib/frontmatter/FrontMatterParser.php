<?php

/**
 * https://github.com/hyn/frontmatter
 * The package require an older version of symfony/yaml than we can do because
 * of other dependencies in projects, so I'm adapting this myself. I don't even
 * want yaml. Yaml is fucking stupid.
 */

namespace src\app\lib\frontmatter;

use cebe\markdown\Parser as MarkdownParser;
use src\app\lib\frontmatter\contracts\Frontmatter;
use \src\app\lib\frontmatter\frontmatters\JsonFrontmatter;

class FrontMatterParser
{
    protected $markdown;

    /** @var Frontmatter */
    protected $frontmatter;

    public function __construct(MarkdownParser $markdown)
    {
        $this->markdown = $markdown;
    }

    /**
     * @param string $frontmatter
     * @return self
     */
    public function setFrontmatter($frontmatter): self
    {
        $this->frontmatter = $frontmatter;
        return $this;
    }

    public function parse($contents): array
    {
        $frontmatter = $this->getFrontmatter($contents);

        $meta = [];

        if ($frontmatter->hasMeta()) {
            $meta = $frontmatter->getMeta();
            $contents = $frontmatter->getContents();
        }

        return [
            'markdown' => $contents,
            'meta' => $meta,
            'html' => $this->markdown->parse($contents)
        ];
    }

    /**
     * @param string $contents
     * @return Frontmatter
     */
    protected function getFrontmatter($contents): Frontmatter
    {
        return $this->frontmatter ? new $this->frontmatter($contents) : new JsonFrontmatter($contents);
    }
}
