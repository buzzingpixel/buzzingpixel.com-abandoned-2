<?php
declare(strict_types=1);

namespace src\app\queue\models;

use DateTime;

/**
 * Class ActionQueueItemModel
 */
class ActionQueueItemModel
{
    /** @var string $guid */
    public $guid;

    /** @var bool $isFinished */
    public $isFinished = false;

    /** @var DateTime $finishedAt */
    public $finishedAt;

    /** @var string $class */
    public $class;

    /** @var string $method */
    public $method;

    /** @var array $context */
    public $context = [];
}
