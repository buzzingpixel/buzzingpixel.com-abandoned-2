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
            ->addColumn('schedule_name', 'string')
            ->addColumn('is_running', 'boolean')
            ->addColumn('last_run_start_at', 'datetime')
            ->addColumn('last_run_start_at_time_zone', 'string')
            ->addColumn('last_run_end_at', 'datetime')
            ->addColumn('last_run_end_at_time_zone', 'string')
            ->create();
    }
}
