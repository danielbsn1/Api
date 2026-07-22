<?php

declare(strict_types=1);

namespace Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use Modules\Auth\Actions\SendPasswordResetLink;
use Modules\Auth\DTOs\SendPasswordResetLinkDTO;
use Modules\Common\Core\Responses\ApiSuccessResponse;

final class PasswordResetLinkController extends Controller
{
    public function store(SendPasswordResetLinkDTO $dto, SendPasswordResetLink $action): ApiSuccessResponse
    {
        $action->handle($dto);

        return new ApiSuccessResponse;
    }
}
