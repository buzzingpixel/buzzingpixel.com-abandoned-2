<?php
declare(strict_types=1);

namespace src\app\queue\services;

use DateTime;
use Exception;
use DateTimeZone;
use src\app\data\factory\AtlasFactory;
use src\app\queue\models\ActionQueueItemModel;
use src\app\data\ActionQueueItem\ActionQueueItem;
use src\app\data\ActionQueueItem\ActionQueueItemRecord;

class MarkItemAsRunService
{
    private $atlas;
    private $updateActionQueueService;

    public function __construct(
        AtlasFactory $atlas,
        UpdateActionQueueService $updateActionQueueService
    ) {
        $this->atlas = $atlas;
        $this->updateActionQueueService = $updateActionQueueService;
    }

    public function __invoke(ActionQueueItemModel $model): void
    {
        $this->markAsRun($model);
    }

    public function markAsRun(ActionQueueItemModel $model): void
    {
        try {
            $dateTime = new DateTime();
            $dateTime->setTimezone(new DateTimeZone('UTC'));

            $atlas = $this->atlas->make();

            /** @var ActionQueueItemRecord $record */
            $record = $atlas->select(ActionQueueItem::class)
                ->where('guid = ', $model->guid)
                ->with(['action_queue'])
                ->fetchRecord();

            $record->is_finished = true;
            $record->finished_at = $dateTime->format('Y-m-d H:i:s');
            $record->finished_at_time_zone = $dateTime->getTimezone()
                ->getName();

            $atlas->persist($record);

            $this->updateActionQueueService->update($record->action_queue_guid);
        } catch (Exception $e) {
        }
    }
}
