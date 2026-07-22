<?php

declare(strict_types=1);

namespace Modules\Auth\Actions;

use Illuminate\Support\Facades\DB;
use Modules\Auth\DTOs\UpdateSettingsDTO;
use Modules\Auth\Settings\AuthSettings;

final readonly class UpdateSettings
{
    public function __construct(private AuthSettings $authSettings) {}

    public function handle(UpdateSettingsDTO $dto): array
    {
        DB::transaction(function () use ($dto) {
            if (isset($dto->auth)) {
                $this->authSettings->fill($dto->auth->toArray());
                $this->authSettings->save();
            }
        });

        return [
            'auth' => $this->authSettings->toArray(),
        ];
    }
}
