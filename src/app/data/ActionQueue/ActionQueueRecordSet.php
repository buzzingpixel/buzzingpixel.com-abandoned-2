<?php
declare(strict_types=1);

namespace src\app\data\ActionQueue;

use Atlas\Mapper\RecordSet;

/**
 * @method ActionQueueRecord offsetGet($offset)
 * @method ActionQueueRecord appendNew(array $fields = [])
 * @method ActionQueueRecord|null getOneBy(array $whereEquals)
 * @method ActionQueueRecordSet getAllBy(array $whereEquals)
 * @method ActionQueueRecord|null detachOneBy(array $whereEquals)
 * @method ActionQueueRecordSet detachAllBy(array $whereEquals)
 * @method ActionQueueRecordSet detachAll()
 * @method ActionQueueRecordSet detachDeleted()
 */
class ActionQueueRecordSet extends RecordSet
{
}
