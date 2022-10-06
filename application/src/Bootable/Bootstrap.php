<?php

namespace KielD01\ClaromentisTestTask\Bootable;

use KielD01\Core\Interfaces\BootableInterface;

class Bootstrap implements BootableInterface
{

    public function boot(array $options = []): void
    {
        array_filter($options, function ($classOrOptions, $indexOrClass) {
            $class = is_string($classOrOptions) ? $classOrOptions : $indexOrClass;
            $options = is_array($classOrOptions) ? $classOrOptions : [];

            /** @var BootableInterface $target */
            $target = new $class();
            $target->boot($options[$class] ?? []);

            ioc()->insert($class, $target);
        }, ARRAY_FILTER_USE_BOTH);
    }
}