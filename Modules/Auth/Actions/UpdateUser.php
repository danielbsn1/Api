<?php

declare(strict_types=1);

namespace Modules\Auth\Actions;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\DTOs\UpdateUserDTO;
use Modules\Auth\Models\User;
use Modules\Common\Core\Exceptions\NotFoundException;

final readonly class UpdateUser
{
    public function handle(string $uuid, UpdateUserDTO $dto): User
    {
        try {
            DB::beginTransaction();

            /** @var User $user */
            $user = User::findByUuid($uuid);

            if (! $user) {
                throw new NotFoundException('User');
            }

            if (isset($dto->password) && $dto->password) {
                $dto->password = Hash::make($dto->password);
            }

            $data = $dto->toArray();

            if (isset($data['password'])) {
                unset($data['password']);
            }

            $user->fill($data);
            $user->save();

            DB::commit();

            return $user;
        } catch (Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }
}
