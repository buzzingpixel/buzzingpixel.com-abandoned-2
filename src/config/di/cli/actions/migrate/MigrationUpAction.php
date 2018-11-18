<?php
declare(strict_types=1);

use Phinx\Console\PhinxApplication;
use src\app\cli\factories\ArrayInputFactory;
use src\app\cli\actions\migrate\MigrationUpAction;
use Symfony\Component\Console\Output\ConsoleOutput;

return [
    MigrationUpAction::class => function () {
        return new MigrationUpAction(
            new PhinxApplication(),
            new ArrayInputFactory(),
            new ConsoleOutput()
        );
    },
];
