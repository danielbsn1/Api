<?php

declare(strict_types=1);

namespace Modules\Common\Core\Exceptions;

class NotFoundException extends BusinessException
{
    public function __construct(string $resource = 'Recurso')
    {
        parent::__construct("{$resource} não encontrado.", 404);
    }
}
