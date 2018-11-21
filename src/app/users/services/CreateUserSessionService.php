<?php
declare(strict_types=1);

namespace src\app\users\services;

use DateTime;
use DateTimeZone;
use src\app\factories\UuidFactory;
use src\app\data\factory\AtlasFactory;
use src\app\data\UserSession\UserSession;
use src\app\users\exceptions\UserDoesNotExistException;

class CreateUserSessionService
{
    private $uuid;
    private $atlas;
    private $fetchUser;

    public function __construct(
        UuidFactory $uuid,
        AtlasFactory $atlas,
        FetchUserService $fetchUser
    ) {
        $this->uuid = $uuid;
        $this->atlas = $atlas;
        $this->fetchUser = $fetchUser;
    }

    /**
     * @throws UserDoesNotExistException
     */
    public function __invoke(string $userGuid): string
    {
        return $this->createUserSession($userGuid);
    }

    /**
     * @throws UserDoesNotExistException
     */
    public function createUserSession(string $userGuid): string
    {
        $fetchUser = $this->fetchUser;
        if (! $fetchUser($userGuid)) {
            throw new UserDoesNotExistException();
        }

        $dateTime = new DateTime();
        $dateTime->setTimezone(new DateTimeZone('UTC'));

        $atlas = $this->atlas->make();

        $record = $atlas->newRecord(UserSession::class);
        $record->guid = $this->uuid->make()->toString();
        $record->user_guid = $userGuid;
        $record->added_at = $dateTime->format('Y-m-d H:i:s');
        $record->added_at_time_zone = $dateTime->getTimezone()->getName();
        $record->last_touched_at = $dateTime->format('Y-m-d H:i:s');
        $record->last_touched_at_time_zone = $dateTime->getTimezone()->getName();

        $atlas->persist($record);

        return $record->guid;
    }
}
