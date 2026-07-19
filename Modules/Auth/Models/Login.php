<?php

declare(strict_types=1);

namespace Modules\Auth\Models;

use Illuminate\Database\Eloquent\Model;

final class Login extends Model
{
    protected $table = 'user_logins';
}
