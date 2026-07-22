<?php

declare(strict_types=1);

namespace Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use Modules\Auth\Actions\FetchSettingsList;
use Modules\Auth\Actions\UpdateSettings;
use Modules\Auth\DTOs\UpdateSettingsDTO;
use Modules\Auth\Resources\SettingsResource;
use Modules\Common\Core\Responses\ApiSuccessResponse;

final class SettingsController extends Controller
{
    public function index(FetchSettingsList $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse(new SettingsResource($action->handle()));
    }

    public function update(UpdateSettingsDTO $dto, UpdateSettings $action): ApiSuccessResponse
    {
        return new ApiSuccessResponse(new SettingsResource($action->handle($dto)));
    }
}
