<?php

declare(strict_types=1);

namespace Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Auth\Actions\FetchUserRolesList;
use Modules\Auth\Actions\SyncUserRoles;
use Modules\Auth\DTOs\SyncUserRolesDTO;
use Modules\Auth\Resources\RoleResource;
use Modules\Common\Core\Responses\NoContentResponse;

final class UserRoleController extends Controller
{
    public function index(string $uuid, FetchUserRolesList $action): JsonResponse
    {
        return response()->json(
            $action->handle($uuid)->map(fn ($role) => [
                'name' => $role->name,
                'description' => $role->description,
            ])
        );
    }

    public function store(SyncUserRolesDTO $dto, string $uuid, SyncUserRoles $action): NoContentResponse
    {
        $action->handle($uuid, $dto);

        return new NoContentResponse();
    }
}
