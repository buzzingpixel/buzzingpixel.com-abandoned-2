<?php
declare(strict_types=1);

namespace src\app\schedule;

use src\app\Di;
use src\app\exceptions\DiBuilderException;
use src\app\schedule\models\ScheduleItemModel;
use src\app\schedule\services\GetScheduleService;
use src\app\schedule\services\SaveScheduleService;

class ScheduleApi
{
    private $di;

    public function __construct(Di $di)
    {
        $this->di = $di;
    }

    /**
     * @throws DiBuilderException
     */
    public function getSchedule(): array
    {
        /** @var GetScheduleService $service */
        $service = $this->di->getFromDefinition(GetScheduleService::class);
        return $service();
    }

    /**
     * @throws DiBuilderException
     */
    public function saveSchedule(ScheduleItemModel $model): void
    {
        /** @var SaveScheduleService $service */
        $service = $this->di->getFromDefinition(SaveScheduleService::class);
        $service($model);
    }
}
