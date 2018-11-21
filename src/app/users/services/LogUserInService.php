<?php
declare(strict_types=1);

namespace src\app\users\services;

use DateTime;
use src\app\cookies\CookieApi;
use src\app\users\exceptions\UserExistsException;
use src\app\users\exceptions\InvalidPasswordException;
use src\app\users\exceptions\UserDoesNotExistException;
use src\app\users\exceptions\InvalidUserModelException;
use src\app\users\exceptions\InvalidEmailAddressException;

class LogUserInService
{
    private $validateUserPassword;
    private $fetchUser;
    private $saveUser;
    private $createUserSession;
    private $cookieApi;

    public function __construct(
        ValidateUserPasswordService $validateUserPassword,
        FetchUserService $fetchUser,
        SaveUserService $saveUser,
        CreateUserSessionService $createUserSession,
        CookieApi $cookieApi
    ) {
        $this->validateUserPassword = $validateUserPassword;
        $this->fetchUser = $fetchUser;
        $this->saveUser = $saveUser;
        $this->createUserSession = $createUserSession;
        $this->cookieApi = $cookieApi;
    }

    /**
     * @throws UserExistsException
     * @throws InvalidPasswordException
     * @throws UserDoesNotExistException
     * @throws InvalidUserModelException
     * @throws InvalidEmailAddressException
     */
    public function __invoke(string $emailAddress, string $password): void
    {
        $this->logUserIn($emailAddress, $password);
    }

    /**
     * @throws UserExistsException
     * @throws InvalidPasswordException
     * @throws UserDoesNotExistException
     * @throws InvalidUserModelException
     * @throws InvalidEmailAddressException
     */
    public function logUserIn(string $emailAddress, string $password): void
    {
        $validateUserPassword = $this->validateUserPassword;
        if (! $validateUserPassword($emailAddress, $password)) {
            throw new InvalidPasswordException();
        }

        $user = $this->fetchUser->fetchUser($emailAddress);

        if (! $user) {
            throw new UserDoesNotExistException();
        }

        if (password_needs_rehash($user->passwordHash, PASSWORD_DEFAULT)) {
            $user->passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $saveUser = $this->saveUser;
            $saveUser($user);
        }

        $dateTime = new DateTime();
        $dateTime->setTimestamp(strtotime('+ 20 years'));

        $createUserSession = $this->createUserSession;
        $sessionId = $createUserSession($user->guid);

        $cookie = $this->cookieApi->makeCookie();

        $cookie->name = 'user_session_token';
        $cookie->value = $sessionId;
        $cookie->expire = $dateTime;

        $this->cookieApi->saveCookie($cookie);
    }
}
