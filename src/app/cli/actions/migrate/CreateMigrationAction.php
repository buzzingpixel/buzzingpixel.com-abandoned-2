<?php
declare(strict_types=1);

namespace src\app\cli\actions\migrate;

use Phinx\Console\PhinxApplication;
use src\app\cli\models\CliArgumentsModel;
use src\app\utilities\CaseConversionService;
use src\app\cli\factories\ArrayInputFactory;
use src\app\cli\services\CliQuestionService;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CreateMigrationAction
 */
class CreateMigrationAction
{
    /** @var CliQuestionService $cliQuestionService */
    private $cliQuestionService;

    /** @var CaseConversionService $caseConversionService */
    private $caseConversionService;

    /** @var PhinxApplication $phinxApplication */
    private $phinxApplication;

    /** @var ArrayInputFactory $arrayInputFactory */
    private $arrayInputFactory;

    /** @var OutputInterface $consoleOutput */
    private $consoleOutput;

    /**
     * CreateMigrationAction constructor
     * @param CliQuestionService $cliQuestionService
     * @param CaseConversionService $caseConversionService
     * @param PhinxApplication $phinxApplication
     * @param ArrayInputFactory $arrayInputFactory
     * @param OutputInterface $consoleOutput
     */
    public function __construct(
        CliQuestionService $cliQuestionService,
        CaseConversionService $caseConversionService,
        PhinxApplication $phinxApplication,
        ArrayInputFactory $arrayInputFactory,
        OutputInterface $consoleOutput
    ) {
        $this->cliQuestionService = $cliQuestionService;
        $this->caseConversionService = $caseConversionService;
        $this->phinxApplication = $phinxApplication;
        $this->arrayInputFactory = $arrayInputFactory;
        $this->consoleOutput = $consoleOutput;
    }

    /**
     * Creates a migration
     * @param CliArgumentsModel $argModel
     * @return null|int
     */
    public function __invoke(CliArgumentsModel $argModel): ?int
    {
        if (! $name = $argModel->getArgumentByIndex(2)) {
            $name = $this->cliQuestionService->ask(
                '<fg=cyan>Provide a migration name: </>'
            );
        }

        $name = $this->caseConversionService->convertStringToPascale($name);

        $input = $this->arrayInputFactory->make([
            'create',
            'name' => $name
        ]);

        return $this->phinxApplication->doRun($input, $this->consoleOutput);
    }
}
