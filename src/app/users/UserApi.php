<?php
declare(strict_types=1);

namespace src\app\users;

use src\app\Di;
use src\app\users\models\UserModel;
use src\app\exceptions\DiBuilderException;
use src\app\users\services\SaveUserService;
use src\app\users\services\LogUserInService;
use src\app\users\services\FetchUserService;
use src\app\users\services\RegisterUserService;
use src\app\users\exceptions\UserExistsException;
use src\app\users\exceptions\InvalidPasswordException;
use src\app\users\exceptions\UserDoesNotExistException;
use src\app\users\services\ValidateUserPasswordService;
use src\app\users\exceptions\PasswordTooShortException;
use src\app\users\exceptions\InvalidUserModelException;
use src\app\users\exceptions\InvalidEmailAddressException;

class UserApi
{
    private $di;

    public function __construct(Di $di)
    {
        $this->di = $di;
    }

    /**
     * @throws DiBuilderException
     * @throws UserExistsException
     * @throws PasswordTooShortException
     * @throws InvalidEmailAddressException
     */
    public function registerUser(string $emailAddress, string $password): void
    {
        /** @var RegisterUserService $service */
        $service = $this->di->getFromDefinition(RegisterUserService::class);
        $service($emailAddress, $password);
    }

    /**
     * @throws DiBuilderException
     */
    public function fetchUser(string $identifier): ?UserModel
    {
        /** @var FetchUserService $service */
        $service = $this->di->getFromDefinition(FetchUserService::class);
        return $service($identifier);
    }

    /**
     * @throws DiBuilderException
     * @throws UserDoesNotExistException
     */
    public function validateUserPassword(
        string $identifier,
        string $password
    ): bool {
        /** @var ValidateUserPasswordService $service */
        $service = $this->di->getFromDefinition(
            ValidateUserPasswordService::class
        );
        return $service($identifier, $password);
    }

    /**
     * @throws DiBuilderException
     * @throws UserExistsException
     * @throws InvalidUserModelException
     * @throws UserDoesNotExistException
     */
    public function saveUser(UserModel $user): void
    {
        /** @var SaveUserService $service */
        $service = $this->di->getFromDefinition(SaveUserService::class);
        $service($user);
    }

    /**
     * @throws DiBuilderException
     * @throws UserExistsException
     * @throws InvalidPasswordException
     * @throws InvalidUserModelException
     * @throws UserDoesNotExistException
     */
    public function logUserIn(string $emailAddress, string $password): void
    {
        /** @var LogUserInService $service */
        $service = $this->di->getFromDefinition(LogUserInService::class);
        $service($emailAddress, $password);
    }
}
