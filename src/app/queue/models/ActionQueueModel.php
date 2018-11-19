<?php
declare(strict_types=1);

namespace src\app\queue\models;

use DateTime;

/**
 * Class ActionQueueModel
 */
class ActionQueueModel
{
    /** @var string $guid */
    public $guid = '';

    /** @var string $name */
    public $name = '';

    /** @var string $title */
    public $title = '';

    /** @var bool $hasStarted */
    public $hasStarted = false;

    /** @var bool $isFinished */
    public $isFinished = false;

    /** @var int $percentComplete */
    public $percentComplete = 0;

    /** @var DateTime $addedAt */
    public $addedAt;

    /** @var DateTime $finishedAt */
    public $finishedAt;

    /** @var array $context */
    public $context = [];

    /** @var ActionQueueItemModel[] $items */
    public $items = [];
}
