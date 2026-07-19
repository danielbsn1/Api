<?php

declare(strict_types=1);

namespace Modules\Common\Core\Enums;

enum Permissions: string
{
    /*
    |--------------------------------------------------------------------------
    | Auth
    |--------------------------------------------------------------------------
    */

    case AUTH_LOGIN = 'auth.login';
    case AUTH_LOGOUT = 'auth.logout';
    case AUTH_MANAGE_SESSIONS = 'auth.manage-sessions';

    /*
    |--------------------------------------------------------------------------
    | Users
    |--------------------------------------------------------------------------
    */

    case USER_VIEW = 'user.view';
    case USER_CREATE = 'user.create';
    case USER_UPDATE = 'user.update';
    case USER_DELETE = 'user.delete';

    /*
    |--------------------------------------------------------------------------
    | Roles
    |--------------------------------------------------------------------------
    */

    case ROLE_VIEW = 'role.view';
    case ROLE_CREATE = 'role.create';
    case ROLE_UPDATE = 'role.update';
    case ROLE_DELETE = 'role.delete';

    /*
    |--------------------------------------------------------------------------
    | Employees
    |--------------------------------------------------------------------------
    */

    case EMPLOYEE_VIEW = 'employee.view';
    case EMPLOYEE_CREATE = 'employee.create';
    case EMPLOYEE_UPDATE = 'employee.update';
    case EMPLOYEE_DELETE = 'employee.delete';

    /*
    |--------------------------------------------------------------------------
    | Companies
    |--------------------------------------------------------------------------
    */

    case COMPANY_VIEW = 'company.view';
    case COMPANY_CREATE = 'company.create';
    case COMPANY_UPDATE = 'company.update';
    case COMPANY_DELETE = 'company.delete';

    /*
    |--------------------------------------------------------------------------
    | Inventory
    |--------------------------------------------------------------------------
    */

    case PRODUCT_VIEW = 'product.view';
    case PRODUCT_CREATE = 'product.create';
    case PRODUCT_UPDATE = 'product.update';
    case PRODUCT_DELETE = 'product.delete';

    /*
    |--------------------------------------------------------------------------
    | Finance
    |--------------------------------------------------------------------------
    */

    case FINANCE_VIEW = 'finance.view';
    case FINANCE_PAY = 'finance.pay';
    case FINANCE_REFUND = 'finance.refund';

    /*
    |--------------------------------------------------------------------------
    | Auth Settings
    |--------------------------------------------------------------------------
    */

    case VIEW_AUTH_SETTINGS = 'view-auth-settings';
    case EDIT_AUTH_SETTINGS = 'edit-auth-settings';

    case IMPERSONATE = 'impersonate';
    case BE_IMPERSONATED = 'be-impersonated';

    /*
    |--------------------------------------------------------------------------
    | Permissions & Roles (for API)
    |--------------------------------------------------------------------------
    */

    case LIST_PERMISSIONS = 'list-permissions';

    case LIST_ROLES = 'list-roles';
    case CREATE_ROLES = 'create-roles';
    case VIEW_ROLES = 'view-roles';
    case EDIT_ROLES = 'edit-roles';
    case DELETE_ROLES = 'delete-roles';

    case LIST_ROLE_PERMISSIONS = 'list-role-permissions';
    case EDIT_ROLE_PERMISSIONS = 'edit-role-permissions';
}
