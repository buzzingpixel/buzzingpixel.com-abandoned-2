<?php
declare(strict_types=1);

namespace src\app\users\services;

use DateTime;
use DateTimeZone;
use src\app\data\User\User;
use src\app\factories\UuidFactory;
use src\app\data\factory\AtlasFactory;
use src\app\users\exceptions\UserExistsException;
use src\app\users\exceptions\PasswordTooShortException;
use src\app\users\exceptions\InvalidEmailAddressException;

class RegisterUserService
{
    public const MIN_PASSWORD_LENGTH = 8;

    private $atlas;
    private $uuid;

    public function __construct(AtlasFactory $atlas, UuidFactory $uuid)
    {
        $this->atlas = $atlas;
        $this->uuid = $uuid;
    }

    /**
     * @throws UserExistsException
     * @throws PasswordTooShortException
     * @throws InvalidEmailAddressException
     */
    public function __invoke(string $emailAddress, string $password): void
    {
        $this->registerUser($emailAddress, $password);
    }

    /**
     * @throws UserExistsException
     * @throws PasswordTooShortException
     * @throws InvalidEmailAddressException
     */
    public function registerUser(string $emailAddress, string $password): void
    {
        if (! filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailAddressException();
        }

        if ($this->doesUserExist($emailAddress)) {
            throw new UserExistsException();
        }

        if (\strlen($password) < self::MIN_PASSWORD_LENGTH) {
            throw new PasswordTooShortException();
        }

        $dateTime = new DateTime();
        $dateTime->setTimezone(new DateTimeZone('UTC'));

        $atlas = $this->atlas->make();

        $record = $atlas->newRecord(User::class);
        $record->guid = $this->uuid->make()->toString();
        $record->email_address = $emailAddress;
        $record->password_hash = password_hash($password, PASSWORD_DEFAULT);
        $record->added_at = $dateTime->format('Y-m-d H:i:s');
        $record->added_at_time_zone = $dateTime->getTimezone()->getName();

        $atlas->persist($record);
    }

    private function doesUserExist(string $emailAddress): bool
    {
        $record = $this->atlas->make()->select(User::class)
            ->where('email_address =', $emailAddress)
            ->fetchRecord();

        return $record !== null;
    }
}
