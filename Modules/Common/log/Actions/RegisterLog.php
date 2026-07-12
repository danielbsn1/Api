<?php

declare(strict_types=1);

namespace Modules\Common\Log\Actions;

use Modules\Common\Core\Actions\BaseAction;
use Modules\Common\Core\Support\ChangeAction;
use Modules\Common\Log\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;

class RegisterLog extends BaseAction
{
    public function __construct(
        private readonly Model $model,
        private readonly ChangeAction $action,
        private readonly ?array $before = null,
    ) {}

    public function handle(): mixed
    {
        return ActivityLog::create([
            'company_id' => auth()->user()?->company_id,
            'user_id'    => auth()->id(),
            'module'     => class_basename($this->model),
            'action'     => $this->action->value,
            'model_type' => $this->model::class,
            'model_id'   => $this->model->getKey(),
            'before'     => $this->before,
            'after'      => $this->model->toArray(),
            'ip'         => request()->ip(),
        ]);
    }
}
