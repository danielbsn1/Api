<?php

declare(strict_types=1);

namespace Modules\Auth\Actions;

use Exception;
use Illuminate\Support\Facades\DB;
use Modules\Auth\DTOs\UpdateRoleDTO;
use Modules\Auth\Models\Role;
use Modules\Common\Core\Exceptions\NotFoundException;

final readonly class UpdateRole
{
    public function handle(int $id, UpdateRoleDTO $dto): Role
    {
        try {
            DB::beginTransaction();

            /** @var Role $role */
            $role = Role::findOrFail($id);

            $role->fill($dto->toArray());
            $role->save();

            DB::commit();

            return $role;
        } catch (Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }
}
