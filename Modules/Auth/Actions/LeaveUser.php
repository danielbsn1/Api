<?php

declare(strict_types=1);

namespace Modules\Auth\Actions;

use Modules\Auth\Support\ImpersonateManager;

final readonly class LeaveUser
{
    public function __construct(private ImpersonateManager $impersonateManager) {}

    public function handle(): string
    {
        return $this->impersonateManager->leave();
    }
}
