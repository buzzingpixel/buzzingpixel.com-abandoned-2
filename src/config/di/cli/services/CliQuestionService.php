<?php
declare(strict_types=1);

use Symfony\Component\Console\Application;
use src\app\cli\services\CliQuestionService;
use Symfony\Component\Console\Input\ArgvInput;
use src\app\cli\factories\ConsoleQuestionFactory;
use Symfony\Component\Console\Output\ConsoleOutput;

return [
    CliQuestionService::class => function () {
        return new CliQuestionService(
            (new Application())
                ->getHelperSet()
                ->get('question'),
            new ArgvInput(),
            new ConsoleOutput(),
            new ConsoleQuestionFactory()
        );
    },
];
