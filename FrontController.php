<?php
declare(strict_types=1);

// phpcs:ignoreFile

$sep = DIRECTORY_SEPARATOR;
define('APP_BASE_PATH', __DIR__);
define('APP_VENDOR_PATH', APP_BASE_PATH . $sep . 'vendor');

require_once APP_VENDOR_PATH . $sep . 'autoload.php';

echo 'hello front controller world!';
