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

        $parsedArguments = [];

        foreach ($rawArguments as $rawArgument) {
            $rawArgument = explode('--', $rawArgument);

            if (\count($rawArgument) < 2) {
                continue;
            }

            unset($rawArgument[0]);
            $rawArgument = $rawArgument[1];

            $rawArgument = explode('=', $rawArgument);

            $parsedArguments[$rawArgument[0]] = $rawArgument[1] ?? '';
        }

        $this->parsedArguments = $parsedArguments;

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
     * @param mixed $fallback
     * @return string|null
     */
    public function getArgument(string $key, $fallback = null): ?string
    {
        return $this->parsedArguments[$key] ?? $fallback;
    }
}
