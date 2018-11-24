<?php
declare(strict_types=1);

namespace src\app\content;

use RegexIterator;
use IteratorIterator;
use DirectoryIterator;
use src\app\lib\frontmatter\FrontMatterParser;

class GetContentFromDirectory
{
    private $frontMatterParser;

    public function __construct(FrontMatterParser $frontMatterParser)
    {
        $this->frontMatterParser = $frontMatterParser;
    }

    public function __invoke(string $path)
    {
        $sep = DIRECTORY_SEPARATOR;

        $iterator = new RegexIterator(
            new IteratorIterator(new DirectoryIterator($path)),
            '/^.+\.md/i',
            RegexIterator::GET_MATCH
        );

        $indexParsed = [];
        $layers = [];

        foreach ($iterator as $files) {
            foreach ($files as $file) {
                $fullPath = $path . $sep . $file;

                $parsed = $this->frontMatterParser->parse(
                    file_get_contents($fullPath)
                );

                if ($file === 'index.md') {
                    $indexParsed = $parsed;
                    continue;
                }

                $layers[] = $parsed;
            }
        }

        return array_merge($indexParsed, [
            'layers' => $layers,
        ]);
    }
}
