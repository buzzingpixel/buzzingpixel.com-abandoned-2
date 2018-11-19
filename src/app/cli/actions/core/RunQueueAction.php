<?php
declare(strict_types=1);

namespace src\app\cli\actions\core;

use Exception;
use src\app\Di;
use src\app\exceptions\DiBuilderException;
use src\app\queue\models\ActionQueueItemModel;
use src\app\queue\services\GetNextQueueItemService;
use src\app\queue\services\MarkAsStoppedDueToError;

/**
 * Class RunQueueAction
 */
class RunQueueAction
{
    private $di;
    private $nextQueueItem;
    private $markAsStoppedDueToError;

    public function __construct(
        Di $di,
        GetNextQueueItemService $nextQueueItem,
        MarkAsStoppedDueToError $markAsStoppedDueToError
    ) {
        $this->di = $di;
        $this->nextQueueItem = $nextQueueItem;
        $this->markAsStoppedDueToError = $markAsStoppedDueToError;
    }

    public function __invoke(): ?int
    {
        $item = $this->nextQueueItem->get(true);

        if (! $item) {
            return null;
        }

        try {
            return $this->run($item);
        } catch (Exception $e) {
            $this->markAsStoppedDueToError->markStopped($item);
            return 1;
        }
    }

    /**
     * @throws DiBuilderException
     */
    private function run(ActionQueueItemModel $item): ?int
    {
        $constructedClass = null;

        if ($this->di->hasDefinition($item->class)) {
            $constructedClass = $this->di->makeFromDefinition($item->class);
        }

        if (! $constructedClass) {
            $constructedClass = new $item->class();
        }

        $constructedClass->{$item->method}($item->context);

        // TODO: Mark item as run

        return null;
    }
}
