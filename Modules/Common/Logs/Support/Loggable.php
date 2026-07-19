<?php

declare(strict_types=1);

namespace Modules\Common\Log\Support;

use Modules\Common\Log\Observers\LogObserver;

trait Loggable
{
    public static function bootLoggable(): void
    {
        static::observe(LogObserver::class);
    }
}
