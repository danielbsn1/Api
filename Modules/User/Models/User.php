<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Modules\Common\Core\Enums\DefaultRole;
use Modules\Common\Core\Models\BaseModel;
use Modules\Common\Log\Support\Loggable;

class User extends BaseModel implements AuthenticatableContract
{
    use Authenticatable;
    use Loggable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            ...parent::casts(),
            'role' => DefaultRole::class,
            'password' => 'hashed',
        ];
    }

    public function hasRole(DefaultRole ...$roles): bool
    {
        return in_array($this->role, $roles);
    }

    public function isAdmin(): bool
    {
        return in_array($this->role, [DefaultRole::ADMIN, DefaultRole::SUPER_ADMIN]);
    }

    public function canManage(): bool
    {
        return $this->role?->level() >= DefaultRole::MANAGER->level();
    }
}
