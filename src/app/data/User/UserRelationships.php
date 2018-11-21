<?php
declare(strict_types=1);

namespace src\app\data\User;

use Atlas\Mapper\MapperRelationships;
use src\app\data\UserSession\UserSession;

class UserRelationships extends MapperRelationships
{
    protected function define(): void
    {
        $this->oneToMany('user_sessions', UserSession::class, [
            'guid' => 'user_guid',
        ]);
    }
}
