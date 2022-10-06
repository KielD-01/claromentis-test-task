<?php

ini_set('display_errors', 1);

use KielD01\ClaromentisTestTask\Bootable\Bootstrap;
use KielD01\ClaromentisTestTask\Bootable\ErrorsHandlerProvider;
use KielD01\ClaromentisTestTask\Bootable\ViewTemplateEngine;
use KielD01\Core\IoC;
use Whoops\Handler\JsonResponseHandler;

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR .
    'bootstrap' . DIRECTORY_SEPARATOR . 'constants.php';

require_once VENDOR . DS . 'autoload.php';

(new IoC())->boot();

require_once CORE . DS . 'Functions' . DS . 'core.php';
require_once CORE . DS . 'Functions' . DS . 'helpers.php';
require_once BOOTSTRAP . DS . 'aliases.php';

$toBoot = [
    ErrorsHandlerProvider::class => [
        'handlers' => [
            !request()->isJson() ?: JsonResponseHandler::class
        ]
    ],
    ViewTemplateEngine::class,
];

$bootable = new Bootstrap();
$bootable->boot($toBoot);

require_once ROUTES . DS . 'web.php';