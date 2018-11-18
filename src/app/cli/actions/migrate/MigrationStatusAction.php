<?php
declare(strict_types=1);

namespace src\app\cli\actions\migrate;

use Phinx\Console\PhinxApplication;
use src\app\cli\factories\ArrayInputFactory;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class MigrationStatusAction
 */
class MigrationStatusAction
{
    /** @var PhinxApplication $phinxApplication */
    private $phinxApplication;

    /** @var ArrayInputFactory $arrayInputFactory */
    private $arrayInputFactory;

    /** @var OutputInterface $consoleOutput */
    private $consoleOutput;

    /**
     * CreateMigrationAction constructor
     * @param PhinxApplication $phinxApplication
     * @param ArrayInputFactory $arrayInputFactory
     * @param OutputInterface $consoleOutput
     */
    public function __construct(
        PhinxApplication $phinxApplication,
        ArrayInputFactory $arrayInputFactory,
        OutputInterface $consoleOutput
    ) {
        $this->phinxApplication = $phinxApplication;
        $this->arrayInputFactory = $arrayInputFactory;
        $this->consoleOutput = $consoleOutput;
    }

    /**
     * Lists migration status
     * @return null|int
     */
    public function __invoke(): ?int
    {
        $input = $this->arrayInputFactory->make(['status']);
        return $this->phinxApplication->doRun($input, $this->consoleOutput);
    }
}
