<?php
declare(strict_types=1);

namespace src\app\users\services;

use DateTime;
use DateTimeZone;
use src\app\data\User\User;
use src\app\data\User\UserRecord;
use src\app\factories\UuidFactory;
use src\app\users\models\UserModel;
use src\app\data\factory\AtlasFactory;
use src\app\users\exceptions\UserExistsException;
use src\app\users\exceptions\UserDoesNotExistException;
use src\app\users\exceptions\InvalidUserModelException;
use src\app\users\exceptions\InvalidEmailAddressException;

class SaveUserService
{
    private $atlas;
    private $uuid;

    public function __construct(AtlasFactory $atlas, UuidFactory $uuid)
    {
        $this->atlas = $atlas;
        $this->uuid = $uuid;
    }

    /**
     * @throws UserExistsException
     * @throws InvalidUserModelException
     * @throws UserDoesNotExistException
     * @throws InvalidEmailAddressException
     */
    public function __invoke(UserModel $userModel): void
    {
        $this->saveUser($userModel);
    }

    /**
     * @throws UserExistsException
     * @throws InvalidUserModelException
     * @throws UserDoesNotExistException
     * @throws InvalidEmailAddressException
     */
    public function saveUser(UserModel $userModel): void
    {
        if (! $userModel->passwordHash ||
            ! $userModel->emailAddress
        ) {
            throw new InvalidUserModelException();
        }

        if (! filter_var($userModel->emailAddress, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailAddressException();
        }

        if (! $userModel->guid) {
            $this->saveNewUser($userModel);
            return;
        }

        $this->saveExistingUser($userModel);
    }

    /**
     * @throws UserExistsException
     */
    private function saveNewUser(UserModel $userModel): void
    {
        if ($this->fetchRecord($userModel->emailAddress)) {
            throw new UserExistsException();
        }

        $dateTime = new DateTime();
        $dateTime->setTimezone(new DateTimeZone('UTC'));

        $atlas = $this->atlas->make();

        $record = $atlas->newRecord(User::class);
        $record->guid = $this->uuid->make()->toString();
        $record->email_address = $userModel->emailAddress;
        $record->password_hash = $userModel->passwordHash;
        $record->added_at = $dateTime->format('Y-m-d H:i:s');
        $record->added_at_time_zone = $dateTime->getTimezone()->getName();

        $atlas->persist($record);
    }

    private function fetchRecord(string $emailAddress): ?UserRecord
    {
        return $this->atlas->make()->select(User::class)
            ->where('email_address =', $emailAddress)
            ->fetchRecord();
    }

    /**
     * @throws UserDoesNotExistException
     */
    private function saveExistingUser(UserModel $userModel): void
    {
        if (! $record = $this->fetchRecord($userModel->emailAddress)) {
            throw new UserDoesNotExistException();
        }

        $record->guid = $userModel->guid;
        $record->email_address = $userModel->emailAddress;
        $record->password_hash = $userModel->passwordHash;

        $this->atlas->make()->persist($record);
    }
}
