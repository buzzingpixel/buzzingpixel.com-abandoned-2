<?php
declare(strict_types=1);

use FastRoute\RouteCollector;

/** @var RouteCollector $routeCollector */

$directory = new RecursiveDirectoryIterator(__DIR__);
$iterator = new RecursiveIteratorIterator($directory);
$finalIterator = new RegexIterator(
    $iterator,
    '/^.+\.php$/i',
    RecursiveRegexIterator::GET_MATCH
);

foreach ($finalIterator as $files) {
    foreach ($files as $file) {
        if (pathinfo($file)['basename'] === '_collector.php') {
            continue;
        }

        include $file;
    }
}
