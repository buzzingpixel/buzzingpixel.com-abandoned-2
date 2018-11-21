<?php
declare(strict_types=1);

namespace src\app\users\services;

use src\app\users\models\UserModel;
use src\app\users\exceptions\UserExistsException;
use src\app\users\exceptions\PasswordTooShortException;
use src\app\users\exceptions\InvalidUserModelException;
use src\app\users\exceptions\UserDoesNotExistException;
use src\app\users\exceptions\InvalidEmailAddressException;

class RegisterUserService
{
    public const MIN_PASSWORD_LENGTH = 8;

    private $saveUser;

    public function __construct(SaveUserService $saveUser)
    {
        $this->saveUser = $saveUser;
    }

    /**
     * @throws UserExistsException
     * @throws PasswordTooShortException
     * @throws InvalidUserModelException
     * @throws UserDoesNotExistException
     * @throws InvalidEmailAddressException
     */
    public function __invoke(string $emailAddress, string $password): void
    {
        $this->registerUser($emailAddress, $password);
    }

    /**
     * @throws UserExistsException
     * @throws PasswordTooShortException
     * @throws InvalidUserModelException
     * @throws UserDoesNotExistException
     * @throws InvalidEmailAddressException
     */
    public function registerUser(string $emailAddress, string $password): void
    {
        if (\strlen($password) < self::MIN_PASSWORD_LENGTH) {
            throw new PasswordTooShortException();
        }

        $model = new UserModel();
        $model->emailAddress = $emailAddress;
        $model->passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $saveUser = $this->saveUser;
        $saveUser($model);
    }
}
