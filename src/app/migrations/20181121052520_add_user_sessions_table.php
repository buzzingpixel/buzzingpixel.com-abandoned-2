<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

/** @noinspection AutoloadingIssuesInspection */
class AddUserSessionsTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('user_sessions')
            ->addColumn('guid', 'string')
            ->addColumn('user_guid', 'text')
            ->addColumn('added_at', 'datetime')
            ->addColumn('added_at_time_zone', 'string')
            ->addColumn('last_touched_at', 'datetime')
            ->addColumn('last_touched_at_time_zone', 'string')
            ->create();
    }
}
