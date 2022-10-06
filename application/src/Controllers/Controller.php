<?php

namespace KielD01\ClaromentisTestTask\Controllers;

abstract class Controller
{
    private array $args = [];

    public function setArgs(array $args)
    {
        array_walk($args, function ($a, $b) {
            dd($a, $b);
        });
    }

    protected function render(string $view, $data = [])
    {
        return ioc()
            ->retrieve('blade')
            ->render($view, $data);
    }
}