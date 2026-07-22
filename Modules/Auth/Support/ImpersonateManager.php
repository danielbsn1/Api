<?php

declare(strict_types=1);

namespace Modules\Auth\Support;

use Illuminate\Auth\AuthManager;
use Illuminate\Foundation\Application;
use Modules\Auth\Actions\FetchUser;
use Modules\Auth\Events\LeaveImpersonation;
use Modules\Auth\Events\TakeImpersonation;
use Modules\Auth\Exceptions\ImpersonationException;
use Modules\Auth\Models\User;

final class ImpersonateManager
{
    private const IMPERSONATED_BY_KEY = 'impersonated_by';

    public function __construct(
        private Application $app,
        private AuthManager $auth,
        private FetchUser $fetchUser,
    ) {}

    public function isImpersonating(): bool
    {
        return ! empty($this->getImpersonatorId());
    }

    public function getImpersonatorId(): ?string
    {
        $value = $this->auth->parseToken()->getPayLoad()->get($this->getImpersonatedByKeyName());

        return $value !== null ? (string) $value : null;
    }

    public function setImpersonatorId(User $impersonator): void
    {
        $this->auth->customClaims([$this->getImpersonatedByKeyName() => $impersonator->uuid]);
    }

    public function take(User $from, User $to): string
    {
        if (! $this->isImpersonating()) {
            if (! ($to->getKey() === $from->getKey())) {
                if ($to->canBeImpersonated()) {
                    if ($from->canImpersonate()) {
                        $this->deferLogout();
                        $this->setImpersonatorId($from);
                        $token = $this->deferLogin($to);

                        event(new TakeImpersonation($from, $to));

                        return $token;
                    }
                    throw new ImpersonationException('Você não tem permissão para impersonar este usuário.');
                } else {
                    throw new ImpersonationException('Este usuário não pode ser impersonado.');
                }
            } else {
                throw new ImpersonationException('Você não pode impersonar a si mesmo.');
            }
        } else {
            throw new ImpersonationException('Você já está impersonando um usuário.');
        }
    }

    public function leave(): string
    {
        if ($this->isImpersonating()) {
            $impersonated = $this->auth->user();
            $impersonator = $this->fetchUser->handle($this->getImpersonatorId());
            $this->deferLogout();
            $this->clear();
            $token = $this->deferLogin($impersonator);

            event(new LeaveImpersonation($impersonator, $impersonated));

            return $token;
        }
        throw new ImpersonationException('Você não está impersonando um usuário.');
    }

    public function retrieveToken(): string
    {
        return (string) $this->auth->getToken();
    }

    public function deferLogout(): void
    {
        $this->auth->logout();
    }

    public function deferLogin(User $impersonator): string
    {
        $token = $this->auth->login($impersonator);
        $this->auth->setToken($token);

        return $token;
    }

    public function clear(): void
    {
        $this->auth->customClaims([$this->getImpersonatedByKeyName() => null]);
    }

    public function getImpersonatedByKeyName(): string
    {
        return self::IMPERSONATED_BY_KEY;
    }
}
