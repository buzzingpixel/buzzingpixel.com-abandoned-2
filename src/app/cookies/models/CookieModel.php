<?php
declare(strict_types=1);

namespace src\app\cookies\models;

use DateTime;

class CookieModel
{
    /** @var string $name */
    public $name;

    /** @var string $value */
    public $value;

    /** @var DateTime $expire */
    public $expire;

    /** @var string $path */
    public $path = '/';

    /** @var string $domain */
    public $domain = '';

    /** @var bool $secure */
    public $secure = false;

    /** @var bool $httpOnly */
    public $httpOnly = true;
}
