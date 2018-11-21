<?php
declare(strict_types=1);

namespace src\app\cli\actions\core;

use Exception;
use src\app\Di;
use src\app\queue\QueueApi;
use src\app\exceptions\DiBuilderException;
use src\app\queue\models\ActionQueueItemModel;

class RunQueueAction
{
    private $di;
    private $queueApi;

    public function __construct(Di $di, QueueApi $queueApi)
    {
        $this->di = $di;
        $this->queueApi = $queueApi;
    }

    /**
     * @throws DiBuilderException
     */
    public function __invoke(): ?int
    {
        $item = $this->queueApi->getNextQueueItem(true);

        if (! $item) {
            return null;
        }

        try {
            return $this->run($item);
        } catch (Exception $e) {
            $this->queueApi->markAsStoppedDueToError($item);
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
            $constructedClass = new $item->class;
        }

        $constructedClass->{$item->method}($item->context);

        $this->queueApi->markItemAsRun($item);

        return null;
    }
}
