<?php

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use KielD01\ClaromentisTestTask\Actions\Api\ProcessCsvAction;
use KielD01\ClaromentisTestTask\Controllers\Controller;
use KielD01\ClaromentisTestTask\Controllers\PagesController;
use KielD01\Core\Action;
use function FastRoute\simpleDispatcher;

$dispatcher = simpleDispatcher(function (RouteCollector $routeCollector) {
    $routeCollector->get('/', [PagesController::class, 'index']);
    $routeCollector->get('/upload', [PagesController::class, 'upload']);

    $routeCollector->addGroup('/api', function (RouteCollector $group) {
        $group->post('/upload', ProcessCsvAction::class);
    });
});

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

$pos = strpos($uri, '?');

$uri = $pos !== false ?
    substr($uri, 0, $pos) :
    rawurldecode($uri);

$route = $dispatcher->dispatch($method, $uri);
[$status] = $route;

switch ($status) {
    case Dispatcher::FOUND:
        [, $handler, $args] = $route;

        $response = null;

        switch (gettype($handler)) {
            case 'array':
                [$controller, $action] = $handler;

                /** @var Controller $instance */
                $instance = new $controller();
                $instance->setArgs($args);

                $response = $instance->{$action}();
                break;
            case 'string':
                /** @var Action $instance */
                $instance = new $handler();
                $response = $instance->handle();
                break;
        }

        echo $response;

        break;
    case Dispatcher::NOT_FOUND:
        /**
         * @ToDo : 404 Page
         */
        break;
    case Dispatcher::METHOD_NOT_ALLOWED:
        /**
         * @ToDo : 403 Forbidden or another error page or any other custom logic
         */
        break;
}