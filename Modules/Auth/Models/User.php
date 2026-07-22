<?php

declare(strict_types=1);

namespace Modules\Auth\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Traits\HasRoles;

final class User extends Authenticatable implements HasMedia, JWTSubject
{
    use CascadeSoftDeletes, HasFactory, HasRoles, InteractsWithMedia, Notifiable, SoftDeletes;

    protected $guard_name = 'api';

    protected $cascadeDeletes = [];

    protected $fillable = [
        'uuid',
        'name',
        'login',
        'email',
        'email_verified_at',
        'password',
        'active',
        'first_login',
        'driver',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @return array<string, mixed>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'active' => 'boolean',
        'first_login' => 'datetime',
        'driver' => 'json',
    ];

    /**
     * The attributes that should be assigned default values.
     *
     * @return array<string, mixed>
     */
    protected $attributes = [
        'active' => true,
    ];

    /**
     * The attributes that are nullable.
     *
     * @return array<string>
     */
    protected $nullable = [
        'driver',
    ];

    public function nullable(): array
    {
        return (new self)->nullable;
    }

    public static function findByUuid(string $uuid): ?self
    {
        return self::where('uuid', $uuid)->first();
    }

    public function scopeAll(Builder $query): Builder
    {
        return $query->withoutGlobalScope('active');
    }

    public function latestLogin()
    {
        return $this->hasOne(Login::class)->latestOfMany();
    }

    public function isFirstLogin(): bool
    {
        return $this->first_login === null;
    }

    public function markAsNotFirstLogin(): void
    {
        $this->update(['first_login' => false]);
    }

    public function isAdmin(): bool
    {
        return $this->hasPermissionTo('ALL-acces-admin-panel');
    }

    public function canImpersonate(): bool
    {
        return $this->hasPermissionTo('impersonate', 'api');
    }

    public function canBeImpersonated(): bool
    {
        return $this->hasPermissionTo('be-impersonated', 'api');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('avatars')
            ->singleFile()
            ->registerMediaConversions(function (Media $media) {
                $this
                    ->addMediaConversion('small')
                    ->width(50)
                    ->height(50);

                $this
                    ->addMediaConversion('medium')
                    ->width(100)
                    ->height(100);

                $this
                    ->addMediaConversion('large')
                    ->width(300)
                    ->height(300);

            });
    }

    public function receivesBroadcastNotificationsOn()
    {
        return 'user.'.$this->uuid;
    }

    protected static function booted(): void
    {
        self::creating(function (User $user) {
            if (empty($user->uuid)) {
                $user->uuid = Str::uuid()->toString();
            }
        });

        self::addGlobalScope(
            'active-users',
            fn (Builder $builder) => $builder->where('active', true)
        );
    }
}
