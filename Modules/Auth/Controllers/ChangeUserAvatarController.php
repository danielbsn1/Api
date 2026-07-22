<?php

declare(strict_types=1);

namespace Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use Modules\Auth\Actions\UpdateUserAvatar;
use Modules\Auth\DTOs\UpdateUserAvatarDTO;
use Modules\Auth\Resources\UserResource;
use Modules\Common\Core\Responses\ApiSuccessResponse;

final class ChangeUserAvatarController extends Controller
{
    public function __invoke(UpdateUserAvatarDTO $dto, string $uuid, UpdateUserAvatar $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse(new UserResource($action->handle($uuid, $dto)));
    }
}
