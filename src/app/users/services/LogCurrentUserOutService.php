<?php
declare(strict_types=1);

namespace src\app\users\services;

use src\app\cookies\CookieApi;
use src\app\data\factory\AtlasFactory;
use src\app\data\UserSession\UserSession;

class LogCurrentUserOutService
{
    private $atlas;
    private $cookieApi;

    public function __construct(AtlasFactory $atlas, CookieApi $cookieApi)
    {
        $this->atlas = $atlas;
        $this->cookieApi = $cookieApi;
    }

    public function __invoke(): void
    {
        $this->logCurrentUserOut();
    }

    public function logCurrentUserOut(): void
    {
        $cookie = $this->cookieApi->retrieveCookie('user_session_token');

        if (! $cookie) {
            return;
        }

        $atlas = $this->atlas->make();

        $record = $atlas->select(UserSession::class)
            ->where('guid =', $cookie->value)
            ->fetchRecord();

        if ($record) {
            $atlas->delete($record);
        }

        $this->cookieApi->deleteCookie($cookie);
    }
}
