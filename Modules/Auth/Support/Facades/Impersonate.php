<?php

declare(strict_types=1);

namespace Modules\Auth\Support\Facades;

use Illuminate\Support\Facades\Facade;

final class Impersonate extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'impersonate';
    }
}
