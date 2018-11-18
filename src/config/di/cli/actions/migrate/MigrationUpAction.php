<?php
declare(strict_types=1);

use Phinx\Console\PhinxApplication;
use src\app\cli\factories\ArrayInputFactory;
use Symfony\Component\Console\Output\ConsoleOutput;
use src\app\cli\actions\migrate\MigrationUpAction;

return [
    MigrationUpAction::class => function () {
        return new MigrationUpAction(
            new PhinxApplication(),
            new ArrayInputFactory(),
            new ConsoleOutput()
        );
    },
];
