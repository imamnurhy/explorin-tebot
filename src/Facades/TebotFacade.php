<?php

namespace Explorin\Tebot\Facades;

use Illuminate\Support\Facades\Facade;

class TebotFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'tebot';
    }
}
