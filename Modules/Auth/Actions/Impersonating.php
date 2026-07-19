<?php

declare(strict_types=1);

namespace Modules\Auth\Actions;

use Illuminate\Support\Facades\Auth;
use Modules\Auth\Support\ImpersonateManager;

final readonly class Impersonating
{
    public function __construct(
        private ImpersonateManager $impersonateManager,
        private FetchUser $fetchUser,
    ) {}

    public function handle(): array
    {
        $impersonated = Auth::user();
        $isImpersonating = $this->impersonateManager->isImpersonating();

        return [
            'type' => 'Bearer',
            'token' => $this->impersonateManager->retrieveToken(),
            'is_impersonating' => $isImpersonating,
            'impersonator' => $isImpersonating
                ? $this->fetchUser->handle($this->impersonateManager->getImpersonatorId())
                : $impersonated,
            'impersonated' => $impersonated,
        ];
    }
}
