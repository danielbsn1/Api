<?php

declare(strict_types=1);

namespace Modules\Auth\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Modules\Auth\Exceptions\ImpersonationException;
use Modules\Auth\Support\ImpersonateManager;

final readonly class ProtectFromImpersonation
{
    public function __construct(private ImpersonateManager $impersonate) {}

    public function handle(Request $request, Closure $next)
    {
        if ($this->impersonate->isImpersonating()) {
            throw new ImpersonationException('Você não pode acessar esta rota enquanto estiver impersonando outro usuário.');
        }

        return $next($request);
    }
}
