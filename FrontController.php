<?php
declare(strict_types=1);

// phpcs:ignoreFile

$sep = DIRECTORY_SEPARATOR;
define('APP_BASE_PATH', __DIR__);
define('APP_VENDOR_PATH', APP_BASE_PATH . $sep . 'vendor');

require APP_VENDOR_PATH . $sep . 'autoload.php';

if (file_exists(APP_BASE_PATH . $sep . '.env')) {
    (new Dotenv\Dotenv(APP_BASE_PATH))->load();
}

if (PHP_SAPI === 'cli') {
    require APP_BASE_PATH . $sep . 'FrontControllerCli.php';
    exit();
}

require APP_BASE_PATH . $sep . 'FrontControllerHttp.php';
exit();
