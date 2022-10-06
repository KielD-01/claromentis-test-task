<?php

namespace KielD01\ClaromentisTestTask\Bootable;

use Jenssegers\Blade\Blade;

class ViewTemplateEngine implements \KielD01\Core\Interfaces\BootableInterface
{

    /**
     * @inheritDoc
     */
    public function boot(array $options = []): void
    {
        ioc()->insert(Blade::class, new Blade(VIEWS, CACHE));
    }
}