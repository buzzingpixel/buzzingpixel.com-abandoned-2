<?php
declare(strict_types=1);

namespace src\app\cli\services;

use src\app\cli\factories\ConsoleQuestionFactory;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\HelperInterface;

/**
 * Class CliQuestionService
 */
class CliQuestionService
{
    /** @var QuestionHelper $questionHelper */
    private $questionHelper;

    /** @var InputInterface $consoleInput */
    private $consoleInput;

    /** @var OutputInterface $consoleOutput */
    private $consoleOutput;

    /** @var ConsoleQuestionFactory $consoleQuestionFactory */
    private $consoleQuestionFactory;

    /**
     * CliQuestionService constructor
     * @param HelperInterface $questionHelper
     * @param InputInterface $consoleInput
     * @param OutputInterface $consoleOutput
     * @param ConsoleQuestionFactory $consoleQuestionFactory
     */
    public function __construct(
        HelperInterface $questionHelper,
        InputInterface $consoleInput,
        OutputInterface $consoleOutput,
        ConsoleQuestionFactory $consoleQuestionFactory
    ) {
        $this->questionHelper = $questionHelper;
        $this->consoleInput = $consoleInput;
        $this->consoleOutput = $consoleOutput;
        $this->consoleQuestionFactory = $consoleQuestionFactory;
    }

    /**
     * Asks a question on the CLI and returns the string response
     * @param string $question
     * @param bool $required
     * @return string
     */
    public function ask(string $question, bool $required = true): string
    {
        $questionEntity = $this->consoleQuestionFactory->make($question);

        $val = '';

        while (! $val) {
            $val = $this->questionHelper->ask(
                $this->consoleInput,
                $this->consoleOutput,
                $questionEntity
            );

            if (! $required) {
                return \is_string($val) ? $val : '';
            }

            if (! $val) {
                $this->consoleOutput->writeln(
                    '<fg=red>You must provide a value</>'
                );
            }
        }

        return $val;
    }
}
