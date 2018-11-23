<?php
declare(strict_types=1);

namespace src\app\http\actions;

use Twig\Environment;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use src\app\http\services\MinifyHtmlService;
use src\app\http\services\WriteHtmlToStaticCacheService;

class RenderHomePageAction
{
    private $twig;
    private $response;
    private $minifyHtml;
    private $writeHtmlToStaticCache;

    public function __construct(
        Environment $twig,
        ResponseInterface $response,
        MinifyHtmlService $minifyHtml,
        WriteHtmlToStaticCacheService $writeHtmlToStaticCache
    ) {
        $this->twig = $twig;
        $this->response = $response;
        $this->minifyHtml = $minifyHtml;
        $this->writeHtmlToStaticCache = $writeHtmlToStaticCache;
    }

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
                    $this->twig->render('StandardPage.twig')
                )
            )
        );

        return $response;
    }
}
