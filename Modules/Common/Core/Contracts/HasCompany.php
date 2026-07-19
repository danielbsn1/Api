<?php

declare(strict_types=1);

namespace Modules\Common\Core\Contracts;

interface HasCompany
{
    public function getCompanyId(): string;
}
