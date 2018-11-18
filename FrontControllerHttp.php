<?php
declare(strict_types=1);

// If we're in dev mode, load up error reporting
if (getenv('DEV_MODE') === 'true') {
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    $whoops = new \Whoops\Run;
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    $whoops->register();
}

throw new Exception('HTTP app exception in dev mode');
