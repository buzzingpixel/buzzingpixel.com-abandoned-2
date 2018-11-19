<?php
declare(strict_types=1);

namespace src\app\queue\services;

use DateTime;
use DateTimeZone;
use src\app\factories\UuidFactory;
use src\app\data\factory\AtlasFactory;
use src\app\data\ActionQueue\ActionQueue;
use src\app\queue\models\ActionQueueModel;
use src\app\queue\models\ActionQueueItemModel;
use src\app\data\ActionQueueItem\ActionQueueItem;
use src\app\queue\exceptions\InvalidActionQueueModel;

/**
 * Class AddToQueueService
 */
class AddToQueueService
{
    /** @var UuidFactory $uuid */
    private $uuid;

    /** @var AtlasFactory $atlas */
    private $atlas;

    /**
     * AddToQueueService constructor
     * @param UuidFactory $uuid
     * @param AtlasFactory $atlas
     */
    public function __construct(
        UuidFactory $uuid,
        AtlasFactory $atlas
    ) {
        $this->uuid = $uuid;
        $this->atlas = $atlas;
    }

    /**
     * Adds an item to the queue
     * @param ActionQueueModel $model
     * @throws InvalidActionQueueModel
     */
    public function __invoke(ActionQueueModel $model): void
    {
        $this->add($model);
    }

    /**
     * Adds an item to the queue
     * @param ActionQueueModel $model
     * @throws InvalidActionQueueModel
     */
    public function add(ActionQueueModel $model): void
    {
        try {
            $this->addModel($model);
        } catch (InvalidActionQueueModel $e) {
            throw $e;
        }
    }

    /**
     * Add model
     * @param ActionQueueModel $model
     * @throws InvalidActionQueueModel
     */
    private function addModel(ActionQueueModel $model): void
    {
        $atlas = $this->atlas->make();

        $dateTime = new DateTime();
        $dateTime->setTimezone(new DateTimeZone('UTC'));

        $this->validateModel($model);
        $this->setGuid($model);

        $items = $atlas->newRecordSet(ActionQueueItem::class);

        $order = 1;

        foreach ($model->items as $item) {
            $items->appendNew([
                'guid' => $item->guid,
                'order_to_run' => $order,
                'action_queue_guid' => $model->guid,
                'is_finished' => false,
                'finished_at' => null,
                'finished_at_time_zone' => null,
                'class' => $item->class,
                'method' => $item->method,
                'context' => json_encode($item->context),
            ]);

            $order++;
        }

        $record = $atlas->newRecord(ActionQueue::class);
        $record->guid = $model->guid;
        $record->name = $model->name;
        $record->title = $model->title;
        $record->has_started = false;
        $record->is_finished = false;
        $record->percent_complete = 0;
        $record->added_at = $dateTime->format('Y-m-d H:i:s');
        $record->added_at_time_zone = $dateTime->getTimezone()->getName();
        $record->finished_at = null;
        $record->finished_at_time_zone = null;
        $record->context = json_encode($model->context);
        $record->action_queue_items = $items;

        $atlas->persist($record);
    }

    /**
     * Validates the model
     * @param ActionQueueModel $model
     * @throws InvalidActionQueueModel
     */
    private function validateModel(ActionQueueModel $model): void
    {
        if (! $model->name ||
            ! $model->title ||
            ! $model->items ||
            ! \is_array($model->items)
        ) {
            throw new InvalidActionQueueModel();
        }

        foreach ($model->items as $item) {
            if (! \is_object($item) ||
                \get_class($item) !== ActionQueueItemModel::class ||
                ! $item->class
            ) {
                throw new InvalidActionQueueModel();
            }

            $item->method = $item->method ?? '__invoke';

            if (! method_exists($item->class, $item->method)) {
                throw new InvalidActionQueueModel();
            }
        }
    }

    /**
     * Sets GUID
     * @param ActionQueueModel $model
     */
    private function setGuid(ActionQueueModel $model): void
    {
        $uuid = $this->uuid->make()->toString();

        $model->guid = $uuid;

        foreach ($model->items as $item) {
            $item->guid = $this->uuid->make()->toString();
        }
    }
}
