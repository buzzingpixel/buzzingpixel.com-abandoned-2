<?php
declare(strict_types=1);

namespace src\app\users\models;

use DateTime;

class UserModel
{
    /** @var string $guid */
    public $guid;

    /** @var string $emailAddress */
    public $emailAddress;

    /** @var string $passwordHash */
    public $passwordHash;

    /** @var DateTime $addedAt */
    public $addedAt;
}
