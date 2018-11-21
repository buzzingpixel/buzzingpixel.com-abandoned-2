<?php
declare(strict_types=1);

use src\app\Di;
use Relay\Relay;
use Middlewares\FastRoute;
use FastRoute\RouteCollector;
use Middlewares\RequestHandler;
use Grafikart\Csrf\CsrfMiddleware;
use src\app\http\ActionParamRouter;
use function FastRoute\simpleDispatcher;
use Zend\Diactoros\ServerRequestFactory;
use Franzl\Middleware\Whoops\WhoopsMiddleware;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;

session_start();

// If we're in dev mode, load up error reporting
if (getenv('DEV_MODE') === 'true') {
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    $whoops = new \Whoops\Run;
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    $whoops->register();
    $middlewareQueue[] = new WhoopsMiddleware();
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
}

/** @noinspection PhpUnhandledExceptionInspection */
$middlewareQueue[] = Di::get(ActionParamRouter::class);

$middlewareQueue[] = new FastRoute(simpleDispatcher(
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
