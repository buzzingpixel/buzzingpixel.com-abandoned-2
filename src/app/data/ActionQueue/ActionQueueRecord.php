<?php
declare(strict_types=1);

namespace src\app\data\ActionQueue;

use Atlas\Mapper\Record;

/**
 * @method ActionQueueRow getRow()
 */
class ActionQueueRecord extends Record
{
    use ActionQueueFields;
}
