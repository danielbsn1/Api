<?php

declare(strict_types=1);

namespace Modules\Auth\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateDomain
{
    public function handle(Request $request, Closure $next): Response
    {
        $domain = $request->header('X-Domain');

        if (! $domain || ! in_array($domain, config('app.allowed_domains', ['foo']))) {
            abort(500, 'Invalid domain.');
        }

        return $next($request);
    }
}
