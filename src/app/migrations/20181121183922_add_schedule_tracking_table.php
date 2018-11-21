<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

/** @noinspection AutoloadingIssuesInspection */
class AddScheduleTrackingTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('schedule_tracking')
            ->addColumn('guid', 'string')
            ->addColumn('is_running', 'boolean', ['default' => '0'])
            ->addColumn('last_run_start_at', 'datetime', ['null' => true])
            ->addColumn('last_run_start_at_time_zone', 'string', ['null' => true])
            ->addColumn('last_run_end_at', 'datetime', ['null' => true])
            ->addColumn('last_run_end_at_time_zone', 'string', ['null' => true])
            ->create();
    }
}
