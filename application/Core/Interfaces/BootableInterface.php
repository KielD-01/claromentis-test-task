<?php

namespace KielD01\Core\Interfaces;

interface BootableInterface
{

    /**
     * Booting up needed functionality
     *
     * @param array $options
     * @return void
     */
    public function boot(array $options = []): void;
}