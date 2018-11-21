<?php
declare(strict_types=1);

namespace src\app\schedule\services;

use src\app\data\factory\AtlasFactory;
use src\app\schedule\models\ScheduleItemModel;
use src\app\data\ScheduleTracking\ScheduleTracking;

class SaveScheduleService
{
    private $atlas;

    public function __construct(AtlasFactory $atlas)
    {
        $this->atlas = $atlas;
    }

    public function __invoke(ScheduleItemModel $model): void
    {
        if (! $model->guid) {
            return;
        }

        $atlas = $this->atlas->make();

        $record = $this->atlas->make()->select(ScheduleTracking::class)
            ->where('guid = ', $model->guid)
            ->fetchRecord();

        if (! $record) {
            $record = $atlas->newRecord(ScheduleTracking::class);
        }

        $record->guid = $model->guid;
        $record->is_running = $model->isRunning;

        $record->last_run_start_at = null;
        $record->last_run_start_at_time_zone = null;
        $record->last_run_end_at = null;
        $record->last_run_end_at_time_zone = null;

        if ($model->lastRunStartAt) {
            $record->last_run_start_at = $model->lastRunStartAt
                ->format('Y-m-d H:i:s');
            $record->last_run_start_at_time_zone = $model->lastRunStartAt
                ->getTimezone()->getName();
        }

        if ($model->lastRunEndAt) {
            $record->last_run_end_at = $model->lastRunEndAt
                ->format('Y-m-d H:i:s');
            $record->last_run_end_at_time_zone = $model->lastRunEndAt
                ->getTimezone()->getName();
        }

        $atlas->persist($record);
    }
}
