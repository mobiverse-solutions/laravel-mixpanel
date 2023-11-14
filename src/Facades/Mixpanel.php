<?php

namespace Mobiverse\LaravelMixpanel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Mixpanel facade
 */
class Mixpanel extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'mixpanel';
    }
}
