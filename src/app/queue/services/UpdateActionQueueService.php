<?php
declare(strict_types=1);

namespace src\app\queue\services;

use DateTime;
use Exception;
use DateTimeZone;
use src\app\data\factory\AtlasFactory;
use src\app\data\ActionQueue\ActionQueue;
use src\app\data\ActionQueue\ActionQueueRecord;
use Atlas\Mapper\Exception as AtlasMapperException;
use src\app\data\ActionQueueItem\ActionQueueItemSelect;

class UpdateActionQueueService
{
    private $atlas;

    public function __construct(
        AtlasFactory $atlas
    ) {
        $this->atlas = $atlas;
    }

    public function __invoke(string $actionQueueGuid): void
    {
        $this->update($actionQueueGuid);
    }

    public function update(string $actionQueueGuid): void
    {
        try {
            $dateTime = new DateTime();
            $dateTime->setTimezone(new DateTimeZone('UTC'));

            $record = $this->fetchActionQueueRecord($actionQueueGuid);

            if (! $record) {
                return;
            }

            $totalItems = $record->action_queue_items->count();
            $totalRun = 0;

            foreach ($record->action_queue_items as $item) {
                if (! $item->is_finished) {
                    continue;
                }

                $totalRun++;
            }

            if ($totalRun >= $totalItems && $record->is_finished) {
                return;
            }

            if ($totalRun >= $totalItems && ! $record->is_finished) {
                $record->is_finished = true;
                $record->finished_at = $dateTime->format('Y-m-d H:i:s');
                $record->finished_at_time_zone = $dateTime->getTimezone()
                    ->getName();
                $record->percent_complete = 100;

                $this->atlas->make()->persist($record);
                return;
            }

            $percentComplete = ($totalRun / $totalItems) * 100;
            $percentComplete = $percentComplete > 100 ? 100 : $percentComplete;
            $percentComplete = $percentComplete < 0 ? 0 : $percentComplete;

            $record->percent_complete = $percentComplete;

            $this->atlas->make()->persist($record);
        } catch (Exception $e) {
        }
    }

    /**
     * @throws AtlasMapperException
     */
    private function fetchActionQueueRecord(
        string $actionQueueGuid
    ): ?ActionQueueRecord {
        /** @var ActionQueueRecord $actionQueueRecord */
        $actionQueueRecord = $this->atlas->make()->select(ActionQueue::class)
            ->where('guid = ', $actionQueueGuid)
            ->with([
                'action_queue_items' => function (ActionQueueItemSelect $selectReplies) {
                    $selectReplies->orderBy('order_to_run ASC');
                }
            ])
            ->fetchRecord();

        return $actionQueueRecord;
    }
}
