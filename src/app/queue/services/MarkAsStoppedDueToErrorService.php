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

class MarkAsStoppedDueToErrorService
{
    private $atlas;

    public function __construct(
        AtlasFactory $atlas
    ) {
        $this->atlas = $atlas;
    }

    public function __invoke(ActionQueueItemModel $model): void
    {
        $this->markStopped($model);
    }

    public function markStopped(ActionQueueItemModel $model): void
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

            $record->action_queue->is_finished = true;
            $record->action_queue->finished_due_to_error = true;
            $record->action_queue->finished_at = $dateTime
                ->format('Y-m-d H:i:s');
            $record->action_queue->finished_at_time_zone = $dateTime
                ->getTimezone()
                ->getName();

            $atlas->persist($record);
        } catch (Exception $e) {
        }
    }
}
