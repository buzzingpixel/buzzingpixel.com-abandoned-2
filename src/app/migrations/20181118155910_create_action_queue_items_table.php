<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

/**
 * Class CreateActionQueueItemsTable
 * @noinspection AutoloadingIssuesInspection
 */
class CreateActionQueueItemsTable extends AbstractMigration
{
    /**
     * Creates the action queue items table
     */
    public function change(): void
    {
        $this->table('action_queue_items')
            ->addColumn('guid', 'string')
            ->addColumn('action_queue_guid', 'string')
            ->addColumn('is_finished', 'boolean', ['default' => '0'])
            ->addColumn('finished_at', 'datetime', ['null' => true])
            ->addColumn('finished_at_time_zone', 'string', ['null' => true])
            ->addColumn('class', 'text')
            ->addColumn('method', 'text')
            ->addColumn('context', 'text', ['null' => true])
            ->create();
    }
}
