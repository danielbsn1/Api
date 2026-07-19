<?php

declare(strict_types=1);

namespace Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Modules\Auth\Actions\DisableTwoFactorAuthentication;
use Modules\Auth\Actions\EnableTwoFactorAuthentication;
use Modules\Auth\Actions\FetchTwoFactorQrCode;
use Modules\Auth\Actions\RegenerateTwoFactorRecoveryCodes;
use Modules\Auth\Actions\ValidateTwoFactor;
use Modules\Auth\DTOs\ConfirmTwoFactorDTO;
use Modules\Auth\Resources\RecoveryCodesResource;
use Modules\Auth\Resources\TwoFactorEnabledResource;
use Modules\Common\Core\Responses\ApiSuccessResponse;

final class TwoFactorController extends Controller
{
    public function enable(EnableTwoFactorAuthentication $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse(new TwoFactorEnabledResource($action->handle()));
    }

    public function disable(DisableTwoFactorAuthentication $action): Response
    {
        $action->handle();

        return response()->noContent();
    }

    public function qrCode(FetchTwoFactorQrCode $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse(new TwoFactorEnabledResource($action->handle()));
    }

    public function confirm(ConfirmTwoFactorDTO $dto, ValidateTwoFactor $action): Response
    {
        if (! $action->handle($dto)) {
            abort(Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->noContent();
    }

    public function regenerateRecoveryCodes(RegenerateTwoFactorRecoveryCodes $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse(new RecoveryCodesResource($action->handle()));
    }
}
