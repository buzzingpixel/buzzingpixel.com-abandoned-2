<?php
declare(strict_types=1);

namespace src\app\data\UserSession;

use src\app\data\User\User;
use Atlas\Mapper\MapperRelationships;

class UserSessionRelationships extends MapperRelationships
{
    protected function define(): void
    {
        $this->manyToOne('user', User::class, [
            'user_guid' => 'guid',
        ]);
    }
}
