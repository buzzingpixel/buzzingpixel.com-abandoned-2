<?php
declare(strict_types=1);

namespace src\app\users;

use src\app\Di;
use src\app\exceptions\DiBuilderException;
use src\app\users\services\RegisterUserService;
use src\app\users\exceptions\UserExistsException;
use src\app\users\exceptions\PasswordTooShortException;
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
        /** @var RegisterUserService $registerUserService */
        $registerUserService = $this->di->getFromDefinition(
            RegisterUserService::class
        );
        $registerUserService($emailAddress, $password);
    }
}
