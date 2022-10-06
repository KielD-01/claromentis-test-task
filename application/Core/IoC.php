<?php

namespace KielD01\Core;

use Exception;
use KielD01\Core\Interfaces\BootableInterface;

/**
 * @method static self getInstance()
 */
final class IoC implements BootableInterface
{
    private static array $classes = [];
    private static array $aliases = [];
    private static bool $allowReplacing = false;
    private static ?self $instance = null;

    public static function __callStatic($name, $arguments)
    {
        if ($name === 'getInstance') {
            return self::$instance;
        }

        return forward_static_call([self::class, $name], ...$arguments);
    }

    public function insert(string $class, $instance): void
    {
        if (array_key_exists($class, $this->getClasses())) {
            if (self::$allowReplacing) {
                self::$classes[$class] = $instance;
            }
            return;
        }

        self::$classes[$class] = $instance;
    }

    /**
     * @param string $classOrAlias
     * @return mixed
     * @throws Exception
     */
    public function retrieve(string $classOrAlias)
    {
        $classes = self::getClasses();
        $aliases = self::getAliases();

        if (array_key_exists($classOrAlias, $aliases)) {
            $classOrAlias = $aliases[$classOrAlias];
        }

        if (!isset($classes[$classOrAlias])) {
            throw new Exception('Failed to retrieve concrete class');
        }

        return $classes[$classOrAlias];
    }

    public static function setAllowReplacing(bool $allow): void
    {
        self::$allowReplacing = $allow;
    }

    public static function getAllowReplacing(): bool
    {
        return self::$allowReplacing;
    }

    public function getClasses(): array
    {
        return self::$classes;
    }

    public function getAliases(): array
    {
        return self::$aliases;
    }

    public function boot(array $options = []): void
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
    }

    public function alias(string $alias, $class)
    {
        self::$aliases[$alias] = $class;
    }
}