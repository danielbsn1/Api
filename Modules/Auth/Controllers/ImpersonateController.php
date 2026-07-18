<?php

declare(strict_types=1);

namespace Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use Modules\Auth\Actions\Impersonating;
use Modules\Auth\Actions\LeaveUser;
use Modules\Auth\Actions\TakeUser;
use Modules\Auth\Resources\ImpersonatingResource;
use Modules\Auth\Resources\TokenResource;
use Modules\Common\Core\Responses\ApiSuccessResponse;

final class ImpersonateController extends Controller
{
    public function take(string $uuid, TakeUser $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse(new TokenResource($action->handle($uuid)));
    }

    public function leave(LeaveUser $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse(new TokenResource($action->handle()));
    }

    public function info(Impersonating $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse(new ImpersonatingResource($action->handle()));
    }
}