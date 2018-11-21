<?php
declare(strict_types=1);

namespace src\app\users\services;

use DateTime;
use DateTimeZone;
use src\app\data\User\User;
use src\app\data\User\UserRecord;
use src\app\users\models\UserModel;
use src\app\data\factory\AtlasFactory;

class FetchUserService
{
    private $atlas;

    public function __construct(AtlasFactory $atlas)
    {
        $this->atlas = $atlas;
    }

    public function __invoke(string $identifier): ?UserModel
    {
        return $this->fetchUser($identifier);
    }

    private $storedUsersByEmail = [];
    private $storedUsersByIdentifier = [];

    public function fetchUser(
        string $identifier,
        $bypassCache = false
    ): ?UserModel {
        if (! $bypassCache &&
            isset($this->storedUsersByEmail[$identifier])
        ) {
            return $this->storedUsersByEmail[$identifier];
        }

        if (! $bypassCache &&
            isset($this->storedUsersByIdentifier[$identifier])
        ) {
            return $this->storedUsersByIdentifier[$identifier];
        }

        $record = $this->fetchRecord($identifier);

        if (! $record) {
            return null;
        }

        $addedAt = new DateTime(
            $record->added_at,
            new DateTimeZone($record->added_at_time_zone)
        );

        $addedAt->setTimezone(new DateTimeZone(date_default_timezone_get()));

        $model = new UserModel();
        $model->guid = $record->guid;
        $model->emailAddress = $record->email_address;
        $model->passwordHash = $record->password_hash;
        $model->addedAt = $addedAt;

        $this->storedUsersByEmail[$model->emailAddress] = $model;
        $this->storedUsersByIdentifier[$model->guid] = $model;

        return $model;
    }

    private function fetchRecord(string $identifier): ?UserRecord
    {
        return $this->atlas->make()->select(User::class)
            ->where('email_address =', $identifier)
            ->orWhere('guid =', $identifier)
            ->fetchRecord();
    }
}
