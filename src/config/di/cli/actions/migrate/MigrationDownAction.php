<?php
declare(strict_types=1);

use src\app\Di;
use Phinx\Console\PhinxApplication;
use src\app\cli\factories\ArrayInputFactory;
use src\app\cli\services\CliQuestionService;
use Symfony\Component\Console\Output\ConsoleOutput;
use src\app\cli\actions\migrate\MigrationDownAction;

return [
    MigrationDownAction::class => function () {
        return new MigrationDownAction(
            new PhinxApplication(),
            new ArrayInputFactory(),
            new ConsoleOutput(),
            Di::get(CliQuestionService::class)
        );
    },
];
