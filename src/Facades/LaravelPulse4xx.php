<?php

namespace Morrislaptop\LaravelPulse4xx\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Morrislaptop\LaravelPulse4xx\LaravelPulse4xx
 */
class LaravelPulse4xx extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Morrislaptop\LaravelPulse4xx\LaravelPulse4xx::class;
    }
}
