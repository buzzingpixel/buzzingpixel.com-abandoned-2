<?php
declare(strict_types=1);

namespace src\app\cli\models;

/**
 * Class CliArgumentsModel
 */
class CliArgumentsModel
{
    /** @var array $rawArguments */
    private $rawArguments = [];

    /** @var array $parsedArguments */
    private $parsedArguments = [];

    /** @var array $parsedArgumentsByIndex */
    private $parsedArgumentsByIndex = [];

    /**
     * CliArgumentsModel constructor
     * @param array $rawArguments
     */
    public function __construct(
        array $rawArguments = []
    ) {
        $this->setRawArguments($rawArguments);
    }

    /**
     * Sets raw arguments array
     * @param array $rawArguments
     * @return CliArgumentsModel
     */
    public function setRawArguments(array $rawArguments): self
    {
        $this->rawArguments = $rawArguments = array_values($rawArguments);

        $index = 0;

        foreach ($rawArguments as $rawArgument) {
            $check = explode('--', $rawArgument);

            if (\count($check) >= 2) {
                unset($check[0]);
                $rawArgument = $check[1];
            }

            $rawArgument = explode('=', $rawArgument);

            $this->parsedArguments[$rawArgument[0]] = $rawArgument[1] ??
                $rawArgument[0];

            $this->parsedArgumentsByIndex[$index] =
                $this->parsedArguments[$rawArgument[0]];

            $index++;
        }

        return $this;
    }

    /**
     * Gets raw arguments
     * @return array
     */
    public function getRawArguments(): array
    {
        return $this->rawArguments;
    }

    /**
     * Gets parsed arguments
     * @return array
     */
    public function getParsedArguments(): array
    {
        return $this->parsedArguments;
    }

    /**
     * Gets a specific argument
     * @param string $key
     * @param null|string $fallback
     * @return string|null
     */
    public function getArgument(string $key, ?string $fallback = null): ?string
    {
        return $this->parsedArguments[$key] ?? $fallback;
    }

    /**
     * Gets an argument value by index
     * @param int $index
     * @param null|string $fallback
     * @return null|string
     */
    public function getArgumentByIndex(int $index, ?string $fallback = null): ?string
    {
        return $this->parsedArgumentsByIndex[$index] ?? $fallback;
    }
}
