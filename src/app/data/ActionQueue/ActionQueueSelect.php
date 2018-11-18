<?php
declare(strict_types=1);

namespace src\app\data\ActionQueue;

use Atlas\Mapper\MapperSelect;

/**
 * @method ActionQueueRecord|null fetchRecord()
 * @method ActionQueueRecord[] fetchRecords()
 * @method ActionQueueRecordSet fetchRecordSet()
 */
class ActionQueueSelect extends MapperSelect
{
}
