<?php

declare(strict_types=1);

namespace Modules\Auth\Exceptions;

use Illuminate\Http\Response;
use Modules\Common\Core\Exceptions\Exception;

class ImpersonationException extends Exception
{
    public function __construct(string $message = 'Ocorreu um erro ao tentar impersonar o usuário.')
    {
        parent::__construct($message, Response::HTTP_FORBIDDEN);
    }
}
