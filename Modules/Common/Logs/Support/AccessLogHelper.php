<?php

declare(strict_types=1);

namespace Modules\Common\Logs\Support;

use Illuminate\Support\Facades\Auth;
use Modules\Common\Core\Support\Modules;
use Modules\Common\Logs\Models\AccessLog as ModelsAccessLog;

final class AccessLogHelper
{
    public static function log(AccessActions $action, Modules $module, ?string $customMessage = null): void
    {
        $user = Auth::guard('api')->user();
        ModelsAccessLog::create([
            'user_name' => $user->name,
            'message' => $customMessage ?? $action->message(),
            'module' => $module->value,
            'action' => $action->value,
        ]);
    }
}
