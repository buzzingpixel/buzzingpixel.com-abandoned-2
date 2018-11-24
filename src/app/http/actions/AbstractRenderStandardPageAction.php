<?php
declare(strict_types=1);

namespace src\app\http\actions;

use Twig\Environment;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use src\app\http\services\MinifyHtmlService;
use src\app\content\GetContentFromDirectory;
use src\app\http\services\WriteHtmlToStaticCacheService;

abstract class AbstractRenderStandardPageAction
{
    private $twig;
    private $response;
    private $minifyHtml;
    private $writeHtmlToStaticCache;
    private $getContentFromDirectory;

    public function __construct(
        Environment $twig,
        ResponseInterface $response,
        MinifyHtmlService $minifyHtml,
        WriteHtmlToStaticCacheService $writeHtmlToStaticCache,
        GetContentFromDirectory $getContentFromDirectory
    ) {
        $this->twig = $twig;
        $this->response = $response;
        $this->minifyHtml = $minifyHtml;
        $this->writeHtmlToStaticCache = $writeHtmlToStaticCache;
        $this->getContentFromDirectory = $getContentFromDirectory;
    }

    abstract protected function getContentDirectoryPath(): string;

    /**
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function __invoke(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ) {
        $response = $this->response->withHeader('Content-Type', 'text/html');

        $response->getBody()->write(
            $this->writeHtmlToStaticCache->write(
                $this->minifyHtml->minifyHtml(
                    $this->twig->render(
                        'StandardPage.twig',
                        ($this->getContentFromDirectory)(
                            $this->getContentDirectoryPath()
                        )
                    )
                )
            )
        );

        return $response;
    }
}
