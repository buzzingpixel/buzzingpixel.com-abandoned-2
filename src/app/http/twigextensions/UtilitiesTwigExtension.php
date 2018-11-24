<?php
declare(strict_types=1);

namespace src\app\http\twigextensions;

use Exception;
use Twig_Filter;
use Twig_Markup;
use Twig_Function;
use Twig_Extension;
use TS\Text\Truncation;
use Michelf\SmartyPants;
use src\app\http\exceptions\Http404Exception;
use src\app\http\exceptions\Http500Exception;

class UtilitiesTwigExtension extends Twig_Extension
{
    /** @var SmartyPants $smartyPants */
    private $smartyPants;

    /**
     * TypesetService constructor
     * @param SmartyPants $smartyPants
     */
    public function __construct(SmartyPants $smartyPants)
    {
        $this->smartyPants = $smartyPants;
    }

    public function getFunctions(): array
    {
        return [
            new Twig_Function('throwHttpError', [$this, 'throwHttpError']),
            new Twig_Function('getenv', [$this, 'getenv']),
            new Twig_Function('fileTime', [$this, 'fileTime']),
            new Twig_Function('buzzingPixelNav', [$this, 'buzzingPixelNav']),
        ];
    }

    public function getFilters()
    {
        return [
            new Twig_Filter('widont', [$this, 'widontFilter']),
            new Twig_Filter('smartypants', [$this, 'smartypantsFilter']),
            new Twig_Filter('typeset', [$this, 'typesetFilter']),
            new Twig_Filter('ucfirst', [$this, 'ucfirstFilter']),
            new Twig_Filter('truncate', [$this, 'truncateFilter']),
        ];
    }

    /**
     * @throws Http404Exception
     * @throws Http500Exception
     */
    public function throwHttpError(int $code = 404, string $msg = ''): void
    {
        if ($code === 404) {
            throw new Http404Exception($msg);
        }

        throw new Http500Exception();
    }

    public function getenv(string $which)
    {
        return getenv($which);
    }

    public function fileTime(string $filePath = '', $uniqidFallback = true): string
    {
        if (file_exists($filePath)) {
            return (string) filemtime($filePath);
        }

        $filePath = ltrim($filePath, '/');
        $newPath = APP_BASE_PATH . '/' . $filePath;

        if (file_exists($newPath)) {
            return (string) filemtime($newPath);
        }

        $filePath = ltrim($filePath, '/');
        $newPath = APP_BASE_PATH . '/public/' . $filePath;

        if (file_exists($newPath)) {
            return (string) filemtime($newPath);
        }

        if ($uniqidFallback) {
            return uniqid('', false);
        }

        return '0';
    }

    private function widont(string $str): string
    {
        // This regex is a beast, tread lightly
        $widontTest = "/([^\s])\s+(((<(a|span|i|b|em|strong|acronym|caps|sub|sup|abbr|big|small|code|cite|tt)[^>]*>)*\s*[^\s<>]+)(<\/(a|span|i|b|em|strong|acronym|caps|sub|sup|abbr|big|small|code|cite|tt)>)*[^\s<>]*\s*(<\/(p|h[1-6]|li)>|$))/i";

        return preg_replace($widontTest, '$1&nbsp;$2', $str);
    }

    public function widontFilter(string $str): Twig_Markup
    {
        return new Twig_Markup($this->widont($str), 'UTF-8');
    }

    public function smartypantsFilter(string $str): Twig_Markup
    {
        return new Twig_Markup($this->smartyPants->transform($str), 'UTF-8');
    }

    public function typesetFilter(string $str): Twig_Markup
    {
        return new Twig_Markup(
            $this->widont($this->smartyPants->transform($str)),
            'UTF-8'
        );
    }

    public function ucfirstFilter(string $val) : Twig_Markup
    {
        return new Twig_Markup(ucfirst($val), 'UTF-8');
    }

    /**
     * @throws Exception
     */
    public function truncateFilter(
        string $val,
        int $limit,
        string $strategy = 'word',
        string $truncationString = '…',
        int $minLength = 0
    ) : Twig_Markup {
        $strategies = [
            'char' => Truncation::STRATEGY_CHARACTER,
            'line' => Truncation::STRATEGY_LINE,
            'paragraph' => Truncation::STRATEGY_PARAGRAPH,
            'sentence' => Truncation::STRATEGY_SENTENCE,
            'word' => Truncation::STRATEGY_WORD,
        ];

        $truncation = new Truncation(
            $limit,
            $strategies[$strategy],
            $truncationString,
            'UTF-8',
            $minLength
        );

        return new Twig_Markup($truncation->truncate($val), 'UTF-8');
    }

    public function buzzingPixelNav(): array
    {
        return json_decode(
            file_get_contents(APP_BASE_PATH . '/src/content/Nav.json'),
            true
        );
    }
}
