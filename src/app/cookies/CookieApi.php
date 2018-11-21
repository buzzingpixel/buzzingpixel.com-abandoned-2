<?php
declare(strict_types=1);

namespace src\app\cookies;

use DateTime;
use src\app\cookies\models\CookieModel;

class CookieApi
{
    private $cookies;

    public function __construct(array $cookies)
    {
        $this->cookies = $cookies;
    }

    public function makeCookie(): CookieModel
    {
        return new CookieModel();
    }

    public function retrieveCookie(string $name): ?CookieModel
    {
        $cookie = $this->cookies[$name] ?? null;

        if (! $cookie) {
            return null;
        }

        $cookieDecode = json_decode($cookie, true);

        $cookieExpireTimeStamp = $cookieDecode['expire'] ?? time();

        $dateTime = new DateTime();
        $dateTime->setTimestamp($cookieExpireTimeStamp);

        $cookieModel = $this->makeCookie();

        $cookieModel->name = $name;
        $cookieModel->value = $cookieDecode['value'] ?? null;
        $cookieModel->expire = $dateTime;
        $cookieModel->path = $cookieDecode['path'] ?? null;
        $cookieModel->domain = $cookieDecode['domain'] ?? null;
        $cookieModel->secure = $cookieDecode['secure'] ?? null;
        $cookieModel->httpOnly = $cookieDecode['httpOnly'] ?? null;

        return $cookieModel;
    }

    public function saveCookie(CookieModel $cookieModel): void
    {
        setcookie(
            $cookieModel->name,
            json_encode([
                'value' => $cookieModel->value,
                'expire' => $cookieModel->expire->getTimestamp(),
                'path' => $cookieModel->path,
                'domain' => $cookieModel->domain,
                'secure' => $cookieModel->secure,
                'httpOnly' => $cookieModel->httpOnly,
            ]),
            $cookieModel->expire->getTimestamp(),
            $cookieModel->path,
            $cookieModel->domain,
            $cookieModel->secure,
            $cookieModel->httpOnly
        );
    }

    public function deleteCookie(CookieModel $cookieModel): void
    {
        $this->deleteCookieByName($cookieModel->name);
    }

    public function deleteCookieByName(string $name): void
    {
        unset($this->cookies[$name]);
        setcookie($name, null, -1);
    }
}
