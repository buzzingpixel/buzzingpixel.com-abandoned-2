<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

/**
 * Class CreateActionQueueTable
 */
class CreateActionQueueTable extends AbstractMigration
{
    /**
     * Creates the action queue table
     */
    public function change(): void
    {
        $this->table('action_queue')
            ->addColumn('has_run', 'boolean', ['default' => '0'])
            ->addColumn('added_at', 'datetime')
            ->addColumn('added_at_time_zone', 'string')
            ->addColumn('finished_at', 'datetime', ['null' => true])
            ->addColumn('finished_at_time_zone', 'string', ['null' => true])
            ->addColumn('class', 'text')
            ->addColumn('method', 'text')
            ->addColumn('context', 'text', ['null' => true])
            ->create();
    }
}
