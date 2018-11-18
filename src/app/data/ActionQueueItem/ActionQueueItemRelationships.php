<?php
declare(strict_types=1);

namespace src\app\data\ActionQueueItem;

use Atlas\Mapper\MapperRelationships;
use src\app\data\ActionQueue\ActionQueue;

class ActionQueueItemRelationships extends MapperRelationships
{
    protected function define(): void
    {
        $this->manyToOne('action_queue', ActionQueue::class, [
            'action_queue_guid' => 'guid',
        ]);
    }
}
