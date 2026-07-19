<?php

declare(strict_types=1);

namespace Modules\Common\Logs\Models;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\Model;

use Modules\Common\Core\Support\Modules;
use Modules\Common\Logs\Support\AccessActions;

class AccessLog extends Model
{
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_name',
        'action',
        'module',
        'message',
    ];

    protected $casts = [
        'action' => AccessActions::class,
        'module' => Modules::class,
    ];

    public function scopeAll(Builder $query): Builder
    {
        return $query;
    }
}