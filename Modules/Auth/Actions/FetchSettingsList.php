<?php

declare(strict_types=1);

namespace Modules\Auth\Actions;

use Modules\Auth\Settings\AuthSettings;

final readonly class FetchSettingsList
{
    public function __construct(private AuthSettings $authSettings) {}

    public function handle(): array
    {
        return [
            'auth' => $this->authSettings->toArray(),
        ];
    }
}
