<?php

namespace Saadzer\LaravelJobChain\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelJobChain extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'LaravelJobChain';
    }
}
