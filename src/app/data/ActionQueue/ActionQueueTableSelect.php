<?php
declare(strict_types=1);

namespace src\app\data\ActionQueue;

use Atlas\Table\TableSelect;

/**
 * @method ActionQueueRow|null fetchRow()
 * @method ActionQueueRow[] fetchRows()
 */
class ActionQueueTableSelect extends TableSelect
{
}
