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
    private const TOKEN_TYPE = 'Bearer';

    public function take(string $uuid, TakeUser $action): ApiSuccessResponse
    {
        $token = $action->handle($uuid);

        return new ApiSuccessResponse(new TokenResource([
            'type' => self::TOKEN_TYPE,
            'token' => $token,
        ]));
    }

    public function leave(LeaveUser $action): ApiSuccessResponse
    {
        $token = $action->handle();

        return new ApiSuccessResponse(new TokenResource([
            'type' => self::TOKEN_TYPE,
            'token' => $token,
        ]));
    }

    public function info(Impersonating $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse(new ImpersonatingResource($action->handle()));
    }
}
