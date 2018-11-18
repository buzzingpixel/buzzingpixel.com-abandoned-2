<?php
declare(strict_types=1);

use FastRoute\RouteCollector;
use src\app\http\actions\RenderHomePageAction;

/** @var RouteCollector $routeCollector */

$routeCollector->get('/', RenderHomePageAction::class);
