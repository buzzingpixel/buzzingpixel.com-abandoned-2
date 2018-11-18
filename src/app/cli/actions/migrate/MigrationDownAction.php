<?php
declare(strict_types=1);

namespace src\app\cli\actions\migrate;

use Phinx\Console\PhinxApplication;
use src\app\cli\models\CliArgumentsModel;
use src\app\cli\factories\ArrayInputFactory;
use src\app\cli\services\CliQuestionService;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class MigrationDownAction
 */
class MigrationDownAction
{
    /** @var PhinxApplication $phinxApplication */
    private $phinxApplication;

    /** @var ArrayInputFactory $arrayInputFactory */
    private $arrayInputFactory;

    /** @var OutputInterface $consoleOutput */
    private $consoleOutput;

    /** @var CliQuestionService $cliQuestionService */
    private $cliQuestionService;

    /**
     * CreateMigrationAction constructor
     * @param PhinxApplication $phinxApplication
     * @param ArrayInputFactory $arrayInputFactory
     * @param OutputInterface $consoleOutput
     * @param CliQuestionService $cliQuestionService
     */
    public function __construct(
        PhinxApplication $phinxApplication,
        ArrayInputFactory $arrayInputFactory,
        OutputInterface $consoleOutput,
        CliQuestionService $cliQuestionService
    ) {
        $this->phinxApplication = $phinxApplication;
        $this->arrayInputFactory = $arrayInputFactory;
        $this->consoleOutput = $consoleOutput;
        $this->cliQuestionService = $cliQuestionService;
    }

    /**
     * Lists migration status
     */
    public function __invoke(CliArgumentsModel $argModel)
    {
        $params = [
            'rollback',
        ];

        if (! $target = $argModel->getArgumentByIndex(2)) {
            $target = $this->cliQuestionService->ask(
                '<fg=cyan>Specify target (0 to revert all, blank to revert last): </>',
                false
            );
        }

        if ($target) {
            $params['--target'] = $target;
        }

        $input = $this->arrayInputFactory->make($params);

        $this->phinxApplication->doRun($input, $this->consoleOutput);
    }
}
