<?php

declare(strict_types=1);

namespace Modules\Common\Core\Actions;

abstract class BaseAction
{
    abstract public function handle(): mixed;
}
