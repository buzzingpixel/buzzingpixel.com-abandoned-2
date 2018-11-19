<?php
declare(strict_types=1);

namespace src\app\cli\actions\core;

use Exception;
use src\app\Di;
use src\app\exceptions\DiBuilderException;
use src\app\queue\services\GetNextQueueItemService;

/**
 * Class RunQueueAction
 */
class RunQueueAction
{
    private $di;
    private $nextQueueItem;

    public function __construct(
        Di $di,
        GetNextQueueItemService $nextQueueItem
    ) {
        $this->di = $di;
        $this->nextQueueItem = $nextQueueItem;
    }

    public function __invoke(): ?int
    {
        try {
            return $this->run();
        } catch (Exception $e) {
            var_dump('TODO: Mark action as stopped due to error');
            return 1;
        }
    }

    /**
     * @throws DiBuilderException
     */
    private function run(): ?int
    {
        $item = $this->nextQueueItem->get(true);

        if (! $item) {
            return null;
        }

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
