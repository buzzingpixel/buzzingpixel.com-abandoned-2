<?php
declare(strict_types=1);

namespace src\app\http;

use Throwable;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use src\app\http\exceptions\Http404Exception;
use src\app\http\actions\RenderErrorPageAction;

class ErrorPages implements MiddlewareInterface
{
    private $renderErrorPage;

    public function __construct(RenderErrorPageAction $renderErrorPage)
    {
        $this->renderErrorPage = $renderErrorPage;
    }

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        try {
            return $handler->handle($request);
        } catch (Throwable $e) {
            return ($this->renderErrorPage)(
                $e instanceof Http404Exception ? 404 : 500
            );
        }
    }
}
