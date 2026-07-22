<?php

declare(strict_types=1);

namespace Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\Auth\Actions\CreateVersa360ScopePermissionMap;
use Modules\Auth\Actions\DeleteVersa360ScopePermissionMap;
use Modules\Auth\Actions\FetchVersa360Client;
use Modules\Auth\Actions\FetchVersa360ScopePermissionMap;
use Modules\Auth\Actions\UpdateVersa360ScopePermissionMap;
use Modules\Auth\DTOs\CreateVersa360ScopePermissionMapDTO;
use Modules\Auth\DTOs\UpdateVersa360ScopePermissionMapDTO;
use Modules\Auth\Resources\Versa360Resource;
use Modules\Common\Core\Responses\ApiSuccessResponse;

final class Versa360Controller extends Controller
{
    public function store(CreateVersa360ScopePermissionMapDTO $dto, CreateVersa360ScopePermissionMap $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse(new Versa360Resource($action->handle($dto)));
    }

    public function client(FetchVersa360Client $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse(new Versa360Resource($action->handle()));
    }

    public function redirect(): RedirectResponse
    {
        return redirect()->away('about:blank')->header('X-Redirect-Handled', 'external');
    }

    public function show(int $scopeId, FetchVersa360ScopePermissionMap $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse(new Versa360Resource($action->handle($scopeId)));
    }

    public function update(int $scopeId, UpdateVersa360ScopePermissionMapDTO $dto, UpdateVersa360ScopePermissionMap $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse(new Versa360Resource($action->handle($scopeId, $dto)));
    }

    public function destroy(int $scopeId, DeleteVersa360ScopePermissionMap $action): void
    {
        $action->handle($scopeId);
    }
}
