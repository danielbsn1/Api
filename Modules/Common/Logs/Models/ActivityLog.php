<?php

declare(strict_types=1);

namespace Modules\Common\Log\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// Herda direto de Model para evitar o global scope de company do BaseModel
class ActivityLog extends Model
{
    use HasUuids;
    use SoftDeletes;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $table = 'activity_logs';

    protected $fillable = [
        'company_id',
        'user_id',
        'module',
        'action',
        'model_type',
        'model_id',
        'before',
        'after',
        'ip',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
            'before' => 'array',
            'after' => 'array',
        ];
    }
}
