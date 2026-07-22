<?php

declare(strict_types=1);

namespace Modules\Auth\Actions;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Modules\Auth\DTOs\NewPasswordDTO;
use Modules\Auth\Models\User;

final readonly class NewPassword
{
    public function handle(NewPasswordDTO $dto): string
    {
        $status = Password::reset(
            $dto->toArray(),
            function (User $user) use ($dto) {
                $user->forceFill([
                    'password' => Hash::make($dto->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        throw_if(
            $status !== Password::PASSWORD_RESET,
            ValidationException::withMessages(['message' => [__($status)]])
        );

        return __($status);
    }
}
