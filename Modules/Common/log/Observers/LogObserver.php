<?php

declare(strict_types=1);

namespace Modules\Common\Log\Observers;

use Modules\Common\Core\Support\ChangeAction;
use Modules\Common\Log\Actions\RegisterLog;
use Modules\Common\Log\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;

class LogObserver
{
    public function created(Model $model): void
    {
        if ($model instanceof ActivityLog) return;

        (new RegisterLog($model, ChangeAction::CREATE))->handle();
    }

    public function updated(Model $model): void
    {
        if ($model instanceof ActivityLog) return;

        (new RegisterLog($model, ChangeAction::UPDATE, $model->getOriginal()))->handle();
    }

    public function deleted(Model $model): void
    {
        if ($model instanceof ActivityLog) return;

        (new RegisterLog($model, ChangeAction::DELETE, $model->toArray()))->handle();
    }
}
