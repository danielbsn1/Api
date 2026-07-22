<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Auth\Controllers\AuthController;
use Modules\Auth\Controllers\ChangeUserAvatarController;
use Modules\Auth\Controllers\ChangeUserPasswordController;
use Modules\Auth\Controllers\ImpersonateController;
use Modules\Auth\Controllers\NewPasswordController;
use Modules\Auth\Controllers\PermissionController;
use Modules\Auth\Controllers\RoleController;
use Modules\Auth\Controllers\RoleMemberController;
use Modules\Auth\Controllers\RolePermissionController;
use Modules\Auth\Controllers\SettingsController;
use Modules\Auth\Controllers\TwoFactorController;
use Modules\Auth\Controllers\UserController;
use Modules\Auth\Controllers\UserRoleController;
use Modules\Auth\Middleware\ValidateDomain;
use Modules\Auth\Middlewares\ProtectFromImpersonation;

// Public Routes
Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login'])
        ->middleware(ValidateDomain::class);
    Route::post('login/2fa', [AuthController::class, 'loginWithTwoFactor'])
        ->middleware(ValidateDomain::class);
    Route::post('refresh', [AuthController::class, 'refresh']);

    Route::post('reset-password', NewPasswordController::class);
});

// Protected Routes
Route::middleware('auth:api')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::prefix('2fa')->group(function () {
            Route::post('enable', [TwoFactorController::class, 'enable']);
            Route::post('confirm', [TwoFactorController::class, 'confirm']);
            Route::delete('disable', [TwoFactorController::class, 'disable']);
            Route::post('regenerate', [TwoFactorController::class, 'regenerateRecoveryCodes']);
            Route::get('qr-code', [TwoFactorController::class, 'qrCode']);
        });

        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'user']);

        Route::prefix('impersonate')->group(function () {
            Route::post('take/{uuid}', [ImpersonateController::class, 'take'])->can('impersonate');
            Route::delete('leave', [ImpersonateController::class, 'leave']);
            Route::get('info', [ImpersonateController::class, 'info'])->can('impersonate');
        });

        Route::middleware(ProtectFromImpersonation::class)->group(function () {
            Route::get('settings', [SettingsController::class, 'index'])->can('view-auth-settings');
            Route::put('settings', [SettingsController::class, 'update'])->can('edit-auth-settings');
        });
    });

    Route::middleware(ProtectFromImpersonation::class)->group(function () {
        Route::prefix('users')->group(function () {
            Route::get('/', [UserController::class, 'index'])->can('user.view');
            Route::post('/', [UserController::class, 'store'])->can('user.create');
            Route::get('/dashboard', [UserController::class, 'dashboard'])->can('user.view');

            Route::prefix('{uuid}')->group(function () {
                Route::get('/', [UserController::class, 'show'])->can('user.view');

                Route::put('/', [UserController::class, 'update']);
                Route::delete('/', [UserController::class, 'destroy'])->can('user.delete');

                Route::put('/password', ChangeUserPasswordController::class)->can('user.update');

                Route::post('avatar', ChangeUserAvatarController::class);

                Route::prefix('roles')->group(function () {
                    Route::get('/', [UserRoleController::class, 'index'])->can('role.view');
                    Route::post('/', [UserRoleController::class, 'store'])->can('role.update');
                });
            });
        });

        Route::get('permissions', [PermissionController::class, 'index'])->can('list-permissions');
        Route::get('permissions/modules', [PermissionController::class, 'modules'])->can('list-permissions');

        Route::prefix('roles')->group(function () {
            Route::get('/', [RoleController::class, 'index'])->can('list-roles');
            Route::post('/', [RoleController::class, 'store'])->can('create-roles');

            Route::prefix('{id}')->group(function () {
                Route::get('/', [RoleController::class, 'show'])->can('view-roles');

                Route::put('/', [RoleController::class, 'update'])->can('edit-roles');
                Route::delete('/', [RoleController::class, 'destroy'])->can('delete-roles');

                Route::prefix('permissions')->group(function () {
                    Route::get('/', [RolePermissionController::class, 'index'])->can('list-role-permissions');
                    Route::post('/', [RolePermissionController::class, 'store'])->can('edit-role-permissions');
                });

                Route::prefix('members')->group(function () {
                    Route::get('/', [RoleMemberController::class, 'index'])->can('view-roles');
                });
            });
        });
    });
});
