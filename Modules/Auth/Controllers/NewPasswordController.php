<?php

declare(strict_types=1);

namespace Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use Modules\Auth\Actions\NewPassword;
use Modules\Auth\DTOs\NewPasswordDTO;
use Modules\Common\Core\Response\ApiSuccessResponse;

final class NewPasswordController extends Controller
{
    public function __invoke(NewPasswordDTO $dto, NewPassword $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse($action->handle($dto));
    }
}