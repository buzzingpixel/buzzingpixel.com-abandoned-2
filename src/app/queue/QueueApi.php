<?php
declare(strict_types=1);

namespace src\app\queue;

use src\app\Di;
use src\app\queue\models\ActionQueueModel;
use src\app\exceptions\DiBuilderException;
use src\app\queue\services\AddToQueueService;
use src\app\queue\models\ActionQueueItemModel;
use src\app\queue\services\MarkItemAsRunService;
use src\app\queue\services\GetNextQueueItemService;
use src\app\queue\services\UpdateActionQueueService;
use src\app\queue\exceptions\InvalidActionQueueModel;
use src\app\queue\services\MarkAsStoppedDueToErrorService;

/**
 * Class AddToQueueService
 */
class QueueApi
{
    private $di;

    public function __construct(Di $di)
    {
        $this->di = $di;
    }

    /**
     * @throws DiBuilderException
     * @throws InvalidActionQueueModel
     */
    public function addToQueue(ActionQueueModel $model): void
    {
        /** @var AddToQueueService $service */
        $service = $this->di->getFromDefinition(AddToQueueService::class);
        $service($model);
    }

    /**
     * @throws DiBuilderException
     */
    public function getNextQueueItem(bool $markAsStarted = false): ?ActionQueueItemModel
    {
        /** @var GetNextQueueItemService $service */
        $service = $this->di->getFromDefinition(GetNextQueueItemService::class);
        return $service($markAsStarted);
    }

    /**
     * @throws DiBuilderException
     */
    public function markAsStoppedDueToError(ActionQueueItemModel $model): void
    {
        /** @var MarkAsStoppedDueToErrorService $service */
        $service = $this->di->getFromDefinition(MarkAsStoppedDueToErrorService::class);
        $service($model);
    }

    /**
     * @throws DiBuilderException
     */
    public function markItemAsRun(ActionQueueItemModel $model): void
    {
        /** @var MarkItemAsRunService $service */
        $service = $this->di->getFromDefinition(MarkItemAsRunService::class);
        $service($model);
    }

    /**
     * @throws DiBuilderException
     */
    public function updateActionQueue(string $actionQueueGuid): void
    {
        /** @var UpdateActionQueueService $service */
        $service = $this->di->getFromDefinition(UpdateActionQueueService::class);
        $service($actionQueueGuid);
    }
}
