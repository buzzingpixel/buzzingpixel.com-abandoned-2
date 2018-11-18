<?php
declare(strict_types=1);

use Atlas\Cli\Fsio;
use Atlas\Cli\Config;
use Atlas\Cli\Logger;
use Atlas\Cli\Skeleton;
use src\app\cli\actions\atlas\GenerateSkeletonAction;

return [
    GenerateSkeletonAction::class => function () {
        return new GenerateSkeletonAction(
            new Skeleton(
                new Config([
                    'pdo' => [
                        'mysql:host=' . getenv('DB_HOST') . ';dbname=' .
                            getenv('DB_DATABASE'),
                        getenv('DB_USER'),
                        getenv('DB_PASSWORD')
                    ],
                    'namespace' => 'src\\app\\data',
                    'directory' => './src/app/data',
                ]),
                new Fsio(),
                new Logger()
            )
        );
    },
];
