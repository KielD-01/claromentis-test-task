<?php

use Illuminate\Http\Response;
use Jenssegers\Blade\Blade;

ioc()->insert(Response::class, new Response());

ioc()->alias('blade', Blade::class);
ioc()->alias('response', Response::class);
