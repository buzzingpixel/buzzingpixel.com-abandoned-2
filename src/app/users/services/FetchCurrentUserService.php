<?php
declare(strict_types=1);

namespace src\app\users\services;

use DateTime;
use Exception;
use DateTimeZone;
use src\app\cookies\CookieApi;
use src\app\users\models\UserModel;
use src\app\data\factory\AtlasFactory;
use src\app\data\UserSession\UserSession;

class FetchCurrentUserService
{
    private $atlas;
    private $cookieApi;
    private $fetchUser;

    public function __construct(
        AtlasFactory $atlas,
        CookieApi $cookieApi,
        FetchUserService $fetchUser
    ) {
        $this->atlas = $atlas;
        $this->cookieApi = $cookieApi;
        $this->fetchUser = $fetchUser;
    }

    public function __invoke(): ?UserModel
    {
        return $this->fetchCurrentUser();
    }

    public function fetchCurrentUser(): ?UserModel
    {
        $cookie = $this->cookieApi->retrieveCookie('user_session_token');

        if (! $cookie) {
            return null;
        }

        $sessionRecord = $this->atlas->make()->select(UserSession::class)
            ->where('guid =', $cookie->value)
            ->fetchRecord();

        if (! $sessionRecord) {
            return null;
        }

        $lastTouchedAt = new DateTime(
            $sessionRecord->last_touched_at,
            new DateTimeZone($sessionRecord->last_touched_at_time_zone)
        );

        $h24 = 86400;
        $diff = time() - $lastTouchedAt->getTimestamp();

        if ($diff > $h24) {
            $dateTime = new DateTime();
            $dateTime->setTimezone(new DateTimeZone('UTC'));
            $sessionRecord->last_touched_at = $dateTime->format('Y-m-d H:i:s');
            $sessionRecord->last_touched_at_time_zone = $dateTime->getTimezone()
                ->getName();
            $this->atlas->make()->persist($sessionRecord);
        }

        try {
            $fetchUser = $this->fetchUser;
            return $fetchUser($sessionRecord->user_guid);
        } catch (Exception $e) {
            return null;
        }
    }
}
