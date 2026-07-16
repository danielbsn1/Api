<?php

declare(strict_types=1);

namespace Modules\User\Policies;

use Modules\Common\Core\Policies\BasePolicy;
use Modules\User\Models\User;

class UserPolicy extends BasePolicy
{
    // Só admin pode listar todos os usuários
    public function viewAny(User $user): bool
    {
        return $this->isAdmin($user);
    }

    // Usuário pode ver a si mesmo, admin e rh_manager veem qualquer um
    public function view(User $user, User $resource): bool
    {
        return $this->isSameUser($user, $resource)
            || $this->isRhManager($user);
    }

    // Só admin e rh_manager criam usuários
    public function create(User $user): bool
    {
        return $this->isRhManager($user);
    }

    // Usuário edita a si mesmo, admin edita qualquer um
    public function update(User $user, User $resource): bool
    {
        return $this->isSameUser($user, $resource)
            || $this->isAdmin($user);
    }

    // Só admin deleta, e não pode deletar a si mesmo
    public function delete(User $user, User $resource): bool
    {
        return $this->isAdmin($user)
            && ! $this->isSameUser($user, $resource);
    }

    // Só admin pode alterar roles
    public function changeRole(User $user): bool
    {
        return $this->isAdmin($user);
    }
}
