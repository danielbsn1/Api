<?php

declare(strict_types=1);

namespace Modules\Auth\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

final class User extends Authenticatable implements HasMedia, JWTSubject
{
    use CascadeSoftDeletes, HasFactory, HasRoles, InteractsWithMedia, Notifiable, SoftDeletes;

    protected $cascadeDeletes = ['posts'];

    protected $fillable = [
        'uuid',
        'name',
        'login',
        'email',
        'email_verified_at',
        'password',
        'acative',
        'first_login',
        'driver',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'acative' => 'boolean',
        'first_login' => 'datetime',
        'driver' => 'json',
    ];

    protected $attributes = [
        'acative' => true,
    ];

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
        return $query->withoutGlobalScope('acative');
    }

    public function traveAllowances()
    {
        return $this->morphMany(TravelAllowance::class, 'allowanceable');
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
            ->addMediaCollections('avatars')
            ->singleFile()
            ->registerMediaCollections(function (Media $media) {
                $this
                    ->addMediaConversion('small')
                    ->width(50)
                    ->height(50);

                $this
                    ->addMediaConversions('medium')
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
        self::addGlobalScope(
            'active-users',
            fn (Builder $builder) => $builder->where('active', true)
        );
    }
}
