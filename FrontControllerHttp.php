<?php
declare(strict_types=1);

use src\app\Di;
use Whoops\Run;
use Relay\Relay;
use src\app\http\ErrorPages;
use FastRoute\RouteCollector;
use Middlewares\RequestHandler;
use src\app\http\RouteProcessor;
use Grafikart\Csrf\CsrfMiddleware;
use src\app\http\ActionParamRouter;
use Whoops\Handler\PrettyPageHandler;
use function FastRoute\simpleDispatcher;
use Zend\Diactoros\ServerRequestFactory;
use Franzl\Middleware\Whoops\WhoopsMiddleware;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;

session_start();

$devMode = getenv('DEV_MODE') === 'true';

// If we're in dev mode, load up error reporting
if ($devMode) {
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    $whoops = new Run();
    $whoops->pushHandler(new PrettyPageHandler);
    $whoops->register();
    $middlewareQueue[] = new WhoopsMiddleware();
}

// If we're not in dev mode, we'll want to capture all the errors
if (! $devMode) {
    /** @noinspection PhpUnhandledExceptionInspection */
    $middlewareQueue[] = Di::get(ErrorPages::class);
}

$uri = trim(ltrim($_SERVER['REQUEST_URI'], '/'), '/');
$uriSegments = explode('/', parse_url($uri, PHP_URL_PATH));

// Ignore these starting URI segments for CsrfChecking
$csrfExempt = [
    'api'
];

if (! in_array($uriSegments[0], $csrfExempt, true)) {
    /** @noinspection PhpUnhandledExceptionInspection */
    $middlewareQueue[] = Di::get(CsrfMiddleware::class);

    /** @noinspection PhpUnhandledExceptionInspection */
    $middlewareQueue[] = Di::get(ActionParamRouter::class);
}

$middlewareQueue[] = new RouteProcessor(simpleDispatcher(
    function (RouteCollector $routeCollector) {
        $sep = DIRECTORY_SEPARATOR;
        require APP_BASE_PATH . $sep . 'src' . $sep .'config' . $sep . 'http' .
            $sep . 'routes' . $sep . '_collector.php';
    }
));

/** @noinspection PhpUnhandledExceptionInspection */
$middlewareQueue[] = new RequestHandler(Di::diContainer());

(new SapiEmitter())->emit((new Relay($middlewareQueue))->handle(
    ServerRequestFactory::fromGlobals()
));
