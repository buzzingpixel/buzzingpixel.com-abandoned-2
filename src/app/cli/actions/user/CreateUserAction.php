<?php
declare(strict_types=1);

namespace src\app\cli\actions\user;

use src\app\users\UserApi;
use src\app\cli\services\CliQuestionService;
use Symfony\Component\Console\Output\OutputInterface;

class CreateUserAction
{
    private $userApi;
    private $consoleOutput;
    private $cliQuestionService;

    public function __construct(
        UserApi $userApi,
        OutputInterface $consoleOutput,
        CliQuestionService $cliQuestionService
    ) {
        $this->userApi = $userApi;
        $this->consoleOutput = $consoleOutput;
        $this->cliQuestionService = $cliQuestionService;
    }

    /**
     * @throws \src\app\exceptions\DiBuilderException
     * @throws \src\app\users\exceptions\InvalidEmailAddressException
     * @throws \src\app\users\exceptions\PasswordTooShortException
     * @throws \src\app\users\exceptions\UserExistsException
     */
    public function __invoke()
    {
        $this->userApi->registerUser(
            $this->cliQuestionService->ask(
                '<fg=cyan>Email address: </>'
            ),
            $this->cliQuestionService->ask(
                '<fg=cyan>Password: </>',
                true,
                true
            )
        );

        $this->consoleOutput->writeln(
            '<fg=green>User registered successfully!</>'
        );
    }
}
