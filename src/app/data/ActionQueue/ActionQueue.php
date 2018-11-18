<?php
declare(strict_types=1);

namespace src\app\data\ActionQueue;

use Atlas\Mapper\Mapper;
use Atlas\Table\Row;

/**
 * @method ActionQueueTable getTable()
 * @method ActionQueueRelationships getRelationships()
 * @method ActionQueueRecord|null fetchRecord($primaryVal, array $with = [])
 * @method ActionQueueRecord|null fetchRecordBy(array $whereEquals, array $with = [])
 * @method ActionQueueRecord[] fetchRecords(array $primaryVals, array $with = [])
 * @method ActionQueueRecord[] fetchRecordsBy(array $whereEquals, array $with = [])
 * @method ActionQueueRecordSet fetchRecordSet(array $primaryVals, array $with = [])
 * @method ActionQueueRecordSet fetchRecordSetBy(array $whereEquals, array $with = [])
 * @method ActionQueueSelect select(array $whereEquals = [])
 * @method ActionQueueRecord newRecord(array $fields = [])
 * @method ActionQueueRecord[] newRecords(array $fieldSets)
 * @method ActionQueueRecordSet newRecordSet(array $records = [])
 * @method ActionQueueRecord turnRowIntoRecord(Row $row, array $with = [])
 * @method ActionQueueRecord[] turnRowsIntoRecords(array $rows, array $with = [])
 */
class ActionQueue extends Mapper
{
}
