<?php

declare(strict_types=1);

namespace Modules\Common\Core\Exceptions;

use Exceptions;

class InvalidEmploymentStatusException extends Exceptions
{
    public function __construct(string $message, int $code = 422)
    {
        parent::__construct($message, $code);
    }
}
