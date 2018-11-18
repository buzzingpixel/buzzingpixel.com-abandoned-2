<?php
declare(strict_types=1);

use src\app\Di;
use Phinx\Console\PhinxApplication;
use src\app\cli\factories\ArrayInputFactory;
use src\app\cli\services\CliQuestionService;
use src\app\utilities\CaseConversionService;
use Symfony\Component\Console\Output\ConsoleOutput;
use src\app\cli\actions\migrate\CreateMigrationAction;

return [
    CreateMigrationAction::class => function () {
        return new CreateMigrationAction(
            Di::get(CliQuestionService::class),
            Di::get(CaseConversionService::class),
            new PhinxApplication(),
            new ArrayInputFactory(),
            new ConsoleOutput()
        );
    },
];
