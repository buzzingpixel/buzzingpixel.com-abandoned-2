<?php
declare(strict_types=1);

namespace src\app\http\actions;

use Twig\Environment;
use Psr\Http\Message\ResponseInterface;
use src\app\http\services\MinifyHtmlService;

class RenderErrorPageAction
{
    private $twig;
    private $response;
    private $minifyHtml;

    public function __construct(
        Environment $twig,
        ResponseInterface $response,
        MinifyHtmlService $minifyHtml
    ) {
        $this->twig = $twig;
        $this->response = $response;
        $this->minifyHtml = $minifyHtml;
    }

    /**
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function __invoke(int $statusCode)
    {
        $response = $this->response->withStatus($statusCode)
            ->withHeader('Content-Type', 'text/html');

        $response->getBody()->write(
            $this->minifyHtml->minifyHtml(
                $this->twig->render('errors/ServerError.twig', [
                    'statusCode' => $statusCode,
                ])
            )
        );

        return $response;
    }
}
