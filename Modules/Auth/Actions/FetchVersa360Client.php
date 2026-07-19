<?php

declare(strict_types=1);

namespace Modules\Auth\Actions;

use Modules\Auth\Models\Versa360Client;

final readonly class FetchVersa360Client
{
    public function handle(): Versa360Client
    {
        return Versa360Client::firstOrFail();
    }
}
