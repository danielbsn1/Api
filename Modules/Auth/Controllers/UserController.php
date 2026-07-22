<?php

declare(strict_types=1);

namespace Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Auth\Actions\CreateUser;
use Modules\Auth\Actions\DeleteUser;
use Modules\Auth\Actions\FetchUser;
use Modules\Auth\Actions\FetchUserCounts;
use Modules\Auth\Actions\FetchUsers;
use Modules\Auth\Actions\UpdateUser;
use Modules\Auth\DTOs\CreateUserDTO;
use Modules\Auth\DTOs\UpdateUserDTO;
use Modules\Auth\Resources\UserResource;
use Modules\Common\Core\Responses\ApiSuccessResponse;
use Modules\Common\Core\Responses\NoContentResponse;

final class UserController extends Controller
{
    public function index(Request $request, FetchUsers $action): JsonResponse
    {
        return UserResource::collection($action->handle($request->input('search'), $request->input('per_page') ? (int) $request->input('per_page') : null))->response();
    }

    public function store(CreateUserDTO $dto, CreateUser $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse(new UserResource($action->handle($dto)), Response::HTTP_CREATED);
    }

    public function dashboard(FetchUserCounts $action): JsonResponse
    {
        return response()->json($action->handle());
    }

    public function show(string $uuid, FetchUser $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse(new UserResource($action->handle($uuid)));
    }

    public function update(string $uuid, UpdateUserDTO $dto, UpdateUser $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse(new UserResource($action->handle($uuid, $dto)));
    }

    public function destroy(string $uuid, DeleteUser $action): NoContentResponse
    {
        $action->handle($uuid);

        return new NoContentResponse;
    }
}
