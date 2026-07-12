<?php

declare(strict_types=1);

namespace Modules\Common\Core\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Common\Core\Contracts\HasCompany;

abstract class BaseModel extends Model
{
    use HasUuids;
    use SoftDeletes;

    protected $keyType = 'string';

    public $incrementing = false;

    protected static function booted(): void
    {
        // Aplica isolamento por empresa apenas em models que implementam HasCompany
        if (is_a(static::class, HasCompany::class, true)) {
            static::addGlobalScope('company', function (Builder $builder) {
                if (auth()->check() && auth()->user()->company_id) {
                    $builder->where('company_id', auth()->user()->company_id);
                }
            });
        }
    }

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }
}
