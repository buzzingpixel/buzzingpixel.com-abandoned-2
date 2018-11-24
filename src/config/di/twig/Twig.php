<?php
declare(strict_types=1);

use src\app\Di;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Extension\DebugExtension;
use src\app\http\twigextensions\UtilitiesTwigExtension;

return [
    Environment::class => function () {
        $debug = getenv('DEV_MODE') === 'true';

        $sep = DIRECTORY_SEPARATOR;

        $loader = new FilesystemLoader(
            APP_BASE_PATH . $sep . 'src' . $sep . 'app' . $sep . 'views'
        );

        $twig = new Environment($loader, [
            'debug' => $debug,
            'cache' => APP_BASE_PATH . $sep . 'cache',
            'strict_variables' => $debug,
        ]);

        $globals = include __DIR__ . $sep . 'globals' . $sep . '_collector.php';

        foreach ($globals as $key => $val) {
            $twig->addGlobal($key, $val);
        }

        $twig->addExtension(Di::get(UtilitiesTwigExtension::class));

        if ($debug) {
            $twig->addExtension(new DebugExtension());
        }

        return $twig;
    },
];
