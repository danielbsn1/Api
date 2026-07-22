<?php

declare(strict_types=1);

namespace Modules\Auth\Exceptions;

use Illuminate\Http\Response;
use Modules\Common\Core\Exceptions\Exception;

class ProtectedRoleException extends Exception
{
    public function __construct()
    {
        parent::__construct(__('auth.exceptions.protected_role'), Response::HTTP_FORBIDDEN);
    }
}
