<?php
declare(strict_types=1);

namespace src\app\cli\actions\core;

use DateTime;
use Throwable;
use src\app\Di;
use DateTimeZone;
use src\app\schedule\ScheduleApi;
use src\app\exceptions\DiBuilderException;
use src\app\schedule\models\ScheduleItemModel;
use Symfony\Component\Console\Output\OutputInterface;

class RunScheduleAction
{
    private $di;
    private $scheduleApi;
    private $consoleOutput;

    public function __construct(
        Di $di,
        ScheduleApi $scheduleApi,
        OutputInterface $consoleOutput
    ) {
        $this->di = $di;
        $this->scheduleApi = $scheduleApi;
        $this->consoleOutput = $consoleOutput;
    }

    public function __invoke()
    {
        $schedule = $this->scheduleApi->getSchedule();

        if (\count($schedule) < 1) {
            $this->consoleOutput->writeln('<fg=yellow>There are no scheduled commands set up</>');
            return;
        }

        array_map([$this, 'runScheduledItem'], $schedule);
    }

    /**
     * @throws DiBuilderException
     */
    private function runScheduledItem(ScheduleItemModel $model): void
    {
        try {
            $this->runScheduleItemInner($model);
        } catch (Throwable $e) {
            $model->isRunning = false;
            $this->scheduleApi->saveSchedule($model);
            $this->consoleOutput->writeln(
                '<fg=red>There was a problem running a scheduled command.</>'
            );
            $this->consoleOutput->writeln(
                '<fg=red>' . $model->class . '::' . $model->method . '</>'
            );
            $this->consoleOutput->writeln(
                '<fg=red>Message: ' . $e->getMessage() . '</>'
            );
        }
    }

    /**
     * @throws DiBuilderException
     */
    private function runScheduleItemInner(ScheduleItemModel $model): void
    {
        if ($model->isRunning && ! $model->shouldRun()) {
            $this->consoleOutput->writeln(
                '<fg=yellow>' . $model->class . '::' . $model->method .
                    ' is currently running</>'
            );

            return;
        }

        if (! $model->shouldRun()) {
            $this->consoleOutput->writeln(
                '<fg=green>' . $model->class . '::' . $model->method .
                    ' does not need run at this time</>'
            );

            return;
        }

        $dateTime = new DateTime();
        $dateTime->setTimezone(new DateTimeZone('UTC'));

        $model->isRunning = true;
        $model->lastRunStartAt = $dateTime;

        $this->scheduleApi->saveSchedule($model);

        $constructedClass = null;

        if ($this->di->hasDefinition($model->class)) {
            $constructedClass = $this->di->makeFromDefinition($model->class);
        }

        if (! $constructedClass) {
            $constructedClass = new $model->class;
        }

        $constructedClass->{$model->method}();

        $dateTime = new DateTime();
        $dateTime->setTimezone(new DateTimeZone('UTC'));

        $model->isRunning = false;
        $model->lastRunEndAt = $dateTime;

        $this->scheduleApi->saveSchedule($model);

        $this->consoleOutput->writeln(
            '<fg=green>' . $model->class . '::' . $model->method .
                ' ran successfully</>'
        );
    }
}
