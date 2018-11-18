<?php
declare(strict_types=1);

namespace src\app\cli\actions\atlas;

use Atlas\Cli\Skeleton;

/**
 * Class GenerateSkeletonAction
 */
class GenerateSkeletonAction
{
    /** @var Skeleton $skeleton */
    private $skeleton;

    /**
     * GenerateSkeletonAction constructor
     * @param Skeleton $skeleton
     */
    public function __construct(Skeleton $skeleton)
    {
        $this->skeleton = $skeleton;
    }

    /**
     * Generates the Atlas data layer skeleton
     * @return null|int
     */
    public function __invoke(): ?int
    {
        $skeleton = $this->skeleton;
        return $skeleton();
    }
}
