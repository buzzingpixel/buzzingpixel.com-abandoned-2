<?php
declare(strict_types=1);

namespace src\app\schedule\services;

use DateTime;
use DateTimeZone;
use src\app\data\factory\AtlasFactory;
use src\app\schedule\models\ScheduleItemModel;
use src\app\data\ScheduleTracking\ScheduleTracking;

class GetScheduleService
{
    private $atlas;
    private $scheduleConfig;

    public function __construct(
        AtlasFactory $atlas,
        array $scheduleConfig
    ) {
        $this->atlas = $atlas;
        $this->scheduleConfig = $this->populateModelDbVals(
            $this->convertConfigToModels($scheduleConfig)
        );
    }

    public function __invoke(): array
    {
        return $this->scheduleConfig;
    }

    /**
     * @return ScheduleItemModel[]
     */
    private function convertConfigToModels(array $scheduleConfig): array
    {
        $models = [];

        foreach ($scheduleConfig as $item) {
            if (! isset($item['class'], $item['runEvery'])) {
                continue;
            }

            $runEvery = strtolower($item['runEvery']);

            if (! isset(ScheduleItemModel::RUN_EVERY_MAP[$runEvery])) {
                continue;
            }

            $model = new ScheduleItemModel();
            $model->class = $item['class'];
            $model->method = $item['method'] ?? '__invoke';
            $model->runEvery = $item['runEvery'];
            $model->guid = md5(implode('-', [
                $model->class,
                $model->method,
                $model->runEvery
            ]));

            $models[] = $model;
        }

        return $models;
    }

    /**
     * @param ScheduleItemModel[] $scheduleModels
     */
    private function populateModelDbVals(array $scheduleModels): array
    {
        $guids = [];

        /** @var ScheduleItemModel[] $modelsByGuid */
        $modelsByGuid = [];

        foreach ($scheduleModels as $model) {
            $modelsByGuid[$model->guid] = $model;
            $guids[$model->guid] = $model->guid;
        }

        $records = $this->atlas->make()->select(ScheduleTracking::class)
            ->where('guid IN ', array_values($guids))
            ->fetchRecords();

        foreach ($records as $record) {
            $guid = $record->guid;
            $model = $modelsByGuid[$guid];

            $model->isRunning = (bool) $record->is_running;

            if ($record->last_run_start_at) {
                $model->lastRunStartAt = new DateTime(
                    $record->last_run_start_at,
                    new DateTimeZone($record->last_run_start_at_time_zone)
                );
            }

            if ($record->last_run_end_at) {
                $model->lastRunEndAt = new DateTime(
                    $record->last_run_end_at,
                    new DateTimeZone($record->last_run_end_at_time_zone)
                );
            }

            $modelsByGuid[$guid] = $model;
        }

        return $modelsByGuid;
    }
}
