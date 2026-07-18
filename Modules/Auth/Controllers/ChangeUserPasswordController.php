<?php

declare(strict_types=1);

namespace Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Auth\Actions\ChangeUserPassword;
use Modules\Auth\DTOs\ChangeUserPasswordDTO;
use Modules\Common\Core\Responses\NoContentResponse;

class ChangeUserPasswordController extends Controller
{
    public function __invoke(Request $request, string $uuid, ChangeUserPassword $action): NoContentResponse
    {
        $action->handle($uuid, ChangeUserPasswordDTO::fromRequest($request));

        return new NoContentResponse();
    }
}