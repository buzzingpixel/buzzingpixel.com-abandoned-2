<?php
declare(strict_types=1);

use src\app\Di;
use src\app\users\UserApi;
use src\app\cli\services\CliQuestionService;
use src\app\cli\actions\user\CreateUserAction;
use Symfony\Component\Console\Output\ConsoleOutput;

return [
    CreateUserAction::class => function () {
        return new CreateUserAction(
            Di::get(UserApi::class),
            new ConsoleOutput(),
            Di::get(CliQuestionService::class)
        );
    },
];
