<?php
declare(strict_types=1);

namespace src\app\queue\services;

use Exception;
use src\app\data\factory\AtlasFactory;
use src\app\data\ActionQueue\ActionQueue;
use src\app\queue\models\ActionQueueItemModel;
use src\app\data\ActionQueue\ActionQueueRecord;
use Atlas\Mapper\Exception as AtlasMapperException;
use src\app\data\ActionQueueItem\ActionQueueItemSelect;

/**
 * Class GetNextQueueItemService
 */
class GetNextQueueItemService
{
    private $atlas;

    public function __construct(
        AtlasFactory $atlas
    ) {
        $this->atlas = $atlas;
    }

    public function __invoke(bool $markAsStarted = false): ?ActionQueueItemModel
    {
        return $this->get($markAsStarted);
    }

    public function get(bool $markAsStarted = false): ?ActionQueueItemModel
    {
        try {
            $actionQueueRecord = $this->fetchActionQueueRecord();

            if (! $actionQueueRecord) {
                return null;
            }

            $item = $actionQueueRecord->action_queue_items->getOneBy([
                'is_finished' => 0
            ]);

            if (! $item) {
                $actionQueueRecord->has_started = true;
                $actionQueueRecord->is_finished = true;
                $actionQueueRecord->percent_complete = 100;
                $this->atlas->make()->persist($actionQueueRecord);
                return null;
            }

            if ($markAsStarted && ! $actionQueueRecord->has_started) {
                $actionQueueRecord->has_started = true;
                $this->atlas->make()->persist($actionQueueRecord);
            }

            $model = new ActionQueueItemModel();
            $model->guid = $item->guid;
            $model->isFinished = false;
            $model->class = $item->class;
            $model->method = $item->method;
            $model->context = json_decode($item->context) ?? [];

            return $model;
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * @throws AtlasMapperException
     */
    private function fetchActionQueueRecord(): ?ActionQueueRecord
    {
        /** @var ActionQueueRecord $actionQueueRecord */
        $actionQueueRecord = $this->atlas->make()->select(ActionQueue::class)
            ->where('is_finished = ', 0)
            ->with([
                'action_queue_items' => function (ActionQueueItemSelect $selectReplies) {
                    $selectReplies
                        ->where('is_finished = ', 0)
                        ->limit(1)
                        ->orderBy('order_to_run ASC');
                }
            ])
            ->orderBy('added_at ASC')
            ->fetchRecord();

        return $actionQueueRecord;
    }
}
