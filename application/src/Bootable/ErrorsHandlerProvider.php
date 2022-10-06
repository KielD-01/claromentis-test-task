<?php

namespace KielD01\ClaromentisTestTask\Bootable;

use KielD01\Core\Interfaces\BootableInterface;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

class ErrorsHandlerProvider implements BootableInterface
{
    private Run $runner;
    private array $options = [];
    private array $handlers = [
        PrettyPageHandler::class
    ];

    public function boot(array $options = []): void
    {
        $this->processOptions($options['options'] ?? []);
        $this->processHandlers($options['handlers'] ?? []);

        $this->initializeRunner();

        $this->processPostOptions();
        $this->processPostHandlers();

        $this->register();
    }

    private function processOptions(array $options = [])
    {
        array_walk($options, function ($value, $option) {
            $this->setOption($option, $value);
        });
    }

    private function processHandlers(array $handlers = [])
    {
        array_map(function ($value, $handler) {
            $this->setHandler($handler);
        }, $handlers);
    }

    private function setOption(string $option, $optionValue)
    {
        $this->options[$option] = $optionValue;
    }

    private function setHandler(string $handler)
    {
        $this->handlers[] = $handler;
    }

    private function getOptions(): array
    {
        return $this->options;
    }

    private function getHandlers(): array
    {
        return $this->handlers;
    }

    private function initializeRunner()
    {
        $this->runner = new Run();
    }

    private function processPostOptions(): void
    {
        array_filter($this->getOptions(), function ($value, $method) {
            $this->runner->{$method}($value);
        }, ARRAY_FILTER_USE_BOTH);
    }

    private function processPostHandlers(): void
    {
        array_map(function (string $handler) {
            $this->runner->pushHandler(new $handler);
        }, $this->getHandlers());
    }

    private function register(): void
    {
        $this->runner->register();
    }
}