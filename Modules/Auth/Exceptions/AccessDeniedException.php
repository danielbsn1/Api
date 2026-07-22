<?php

declare(strict_types=1);

namespace Modules\Auth\Exceptions;

use Illuminate\Http\Response;
use Modules\Common\Core\Exceptions\Exception;

class AccessDeniedException extends Exception
{
    public function __construct(string $message = 'Acesso negado.')
    {
        parent::__construct($message, Response::HTTP_FORBIDDEN);
    }
}
