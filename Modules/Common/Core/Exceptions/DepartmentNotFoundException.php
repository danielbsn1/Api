<?php

declare(strict_types=1);

namespace Modules\Common\Core\Exceptions;

class DepartmentNotFoundException extends Exception
{
    public function __construct(string $message, int $code = 422)
    {
        parent::__construct($message, $code);
    }
}
