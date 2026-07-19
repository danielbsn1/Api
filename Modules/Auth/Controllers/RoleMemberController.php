<?php

declare(strict_types=1);

namespace Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Auth\Actions\FetchRoleMembersList;
use Modules\Auth\Resources\UserResource;

final class RoleMemberController extends Controller
{
    public function index(int $id, FetchRoleMembersList $action): JsonResponse
    {
        return UserResource::collection($action->handle($id))->response();
    }
}
