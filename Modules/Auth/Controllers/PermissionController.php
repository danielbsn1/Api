<?php

declare(strict_types=1);

namespace Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Auth\Actions\FetchPermissionsList;
use Modules\Auth\Actions\FetchPermissionsModules;
use Modules\Auth\Resources\PermissionResource;
use Modules\Common\Core\Responses\ApiSuccessResponse;

final class PermissionController extends Controller
{
    public function index(FetchPermissionsList $action): JsonResponse
    {
        return PermissionResource::collection($action->handle())->response();
    }

    public function modules(FetchPermissionsModules $action): JsonResponse
    {
        return response()->json($action->handle());
    }
}
