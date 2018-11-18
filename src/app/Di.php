<?php
declare(strict_types=1);

namespace src\app;

use Exception;
use DI\Container;
use DI\ContainerBuilder;
use src\app\exceptions\DiBuilderException;

/**
 * Class Di
 */
class Di
{
    /** @var Container $diContainer */
    private static $diContainer;

    /**
     * Gets the DI Container
     * @return Container
     * @throws DiBuilderException
     */
    public static function diContainer(): Container
    {
        if (self::$diContainer) {
            return self::$diContainer;
        }

        try {
            $sep = DIRECTORY_SEPARATOR;
            $diConfig = require APP_BASE_PATH . $sep . 'src' . $sep . 'config' . $sep . 'di' . $sep . '_collector.php';

            self::$diContainer = (new ContainerBuilder())
                ->useAutowiring(false)
                ->useAnnotations(false)
                ->addDefinitions($diConfig)
                ->build();
        } catch (Exception $e) {
            $msg = 'Unable to build Dependency Injection Container';

            throw new DiBuilderException($msg, 500, $e);
        }

        return self::$diContainer;
    }

    /**
     * Gets the DI Container
     * @return Container
     * @throws DiBuilderException
     */
    public function getDiContainer(): Container
    {
        return self::diContainer();
    }

    /**
     * Resolves a dependency (if a dependency has already been resolved, then
     * that same instance of the dependency will be returned)
     * @param string $def
     * @return mixed
     * @throws DiBuilderException
     */
    public static function get(string $def)
    {
        try {
            return self::diContainer()->get($def);
        } catch (Exception $e) {
            $msg = 'Unable to get dependency';
            throw new DiBuilderException($msg, 500, $e);
        }
    }

    /**
     * Resolves a dependency (if a dependency has already been resolved, then
     * that same instance of the dependency will be returned)
     * @param string $def
     * @return mixed
     * @throws DiBuilderException
     */
    public function getFromDefinition(string $def)
    {
        return self::get($def);
    }

    /**
     * Resolves a dependency with a new instance of that dependency every time
     * @param string $def
     * @return mixed
     * @throws DiBuilderException
     */
    public static function make(string $def)
    {
        try {
            return self::diContainer()->make($def);
        } catch (Exception $e) {
            $msg = 'Unable to make dependency';
            throw new DiBuilderException($msg, 500, $e);
        }
    }

    /**
     * Resolves a dependency with a new instance of that dependency every time
     * @param string $def
     * @return mixed
     * @throws DiBuilderException
     */
    public function makeFromDefinition(string $def)
    {
        return self::make($def);
    }

    /**
     * Checks if the DI has a dependency definition
     * @param string $def
     * @return mixed
     * @throws DiBuilderException
     */
    public static function has(string $def)
    {
        try {
            return self::diContainer()->has($def);
        } catch (Exception $e) {
            $msg = 'Unable to check if container has dependency';
            throw new DiBuilderException($msg, 500, $e);
        }
    }

    /**
     * Checks if the DI has a dependency definition
     * @param string $def
     * @return mixed
     * @throws DiBuilderException
     */
    public function hasDefinition(string $def)
    {
        return self::make($def);
    }
}
