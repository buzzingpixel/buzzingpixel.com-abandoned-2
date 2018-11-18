<?php
declare(strict_types=1);

use src\app\cli\actions\core\ActionsAction;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;

return [
    ActionsAction::class => function () {
        $sep = DIRECTORY_SEPARATOR;
        $actions = include APP_BASE_PATH . $sep . 'src' . $sep . 'config' . $sep . 'cli'
            . $sep . 'actions' . $sep . '_collector.php';

        return new ActionsAction(
            new ConsoleOutput(),
            $actions
        );
    },
];
