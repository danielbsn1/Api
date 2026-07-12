<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Modules\Common\Core\Enums\Role;
use Modules\Common\Core\Models\BaseModel;
use Modules\Common\Log\Support\Loggable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

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
            'role'     => Role::class,
            'password' => 'hashed',
        ];
    }

    public function hasRole(Role ...$roles): bool
    {
        return in_array($this->role, $roles);
    }

    public function isAdmin(): bool
    {
        return $this->role === Role::ADMIN;
    }

    public function canManage(): bool
    {
        return $this->role?->canManage() ?? false;
    }
}
