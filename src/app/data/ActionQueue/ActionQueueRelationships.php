<?php
declare(strict_types=1);

namespace src\app\data\ActionQueue;

use Atlas\Mapper\MapperRelationships;
use src\app\data\ActionQueueItem\ActionQueueItem;

class ActionQueueRelationships extends MapperRelationships
{
    protected function define(): void
    {
        $this->oneToMany('action_queue_items', ActionQueueItem::class, [
            'guid' => 'action_queue_guid',
        ]);
    }
}
