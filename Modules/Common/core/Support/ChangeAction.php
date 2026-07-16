<?php

declare(strict_types=1);

namespace Modules\Common\Core\Support;

enum ChangeAction: string
{
    case CREATE = 'CREATED';
    case UPDATE = 'UPDATED';
    case DELETE = 'DELETED';
}
