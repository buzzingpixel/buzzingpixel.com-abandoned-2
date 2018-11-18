<?php
declare(strict_types=1);

namespace src\app\cli\factories;

use Symfony\Component\Console\Input\ArrayInput;

/**
 * Class ArrayInputFactory
 */
class ArrayInputFactory
{
    /**
     * Gets a ArrayInput instance
     * @param array $params
     * @return ArrayInput
     */
    public function make(array $params): ArrayInput
    {
        return new ArrayInput($params);
    }
}
