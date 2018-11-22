<?php
declare(strict_types=1);

namespace src\app\http\actions;

use Twig\Environment;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RenderHomePageAction
{
    private $twig;
    private $response;

    public function __construct(Environment $twig, ResponseInterface $response)
    {
        $this->twig = $twig;
        $this->response = $response;
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
        $response->getBody()->write($this->twig->render('index.twig'));
        return $response;
    }
}
