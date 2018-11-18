<?php
declare(strict_types=1);

use src\app\Di;
use NunoMaduro\Collision\Provider as Collision;
use src\app\cli\exceptions\ActionNotFoundException;
use src\app\cli\exceptions\InvalidActionArgumentException;

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
(new Collision)->register();

$sep = DIRECTORY_SEPARATOR;

$actions = include APP_BASE_PATH . $sep . 'src' . $sep . 'config' . $sep . 'cli'
    . $sep . 'actions' . $sep . '_collector.php';

$action = explode('/', $argv[1] ?? 'core/actions');

if (count($action) !== 2) {
    /** @noinspection PhpUnhandledExceptionInspection */
    throw new InvalidActionArgumentException('Invalid action');
}

$action = $actions[$action[0]]['commands'][$action[1]] ?? null;

if (! $action) {
    /** @noinspection PhpUnhandledExceptionInspection */
    throw new ActionNotFoundException();
}

$actionClass = $action['class'] ?? '';
$actionMethod = $action['method'] ?? '__invoke';

if (! $actionClass) {
    /** @noinspection PhpUnhandledExceptionInspection */
    throw new ActionNotFoundException();
}

$class = null;

/** @noinspection PhpUnhandledExceptionInspection */
if (Di::has($actionClass)) {
    /** @noinspection PhpUnhandledExceptionInspection */
    $class = Di::get($actionClass);
}

if (! $class) {
    $class = new $actionClass;
}

// TODO: parse arguments and send them to the action in some manner

$class->{$actionMethod}();
