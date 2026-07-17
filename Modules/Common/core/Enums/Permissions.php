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

    // ...


    public function all(): array
    {
        return [
            self::AUTH_LOGIN,
            self::AUTH_LOGOUT,
            self::AUTH_MANAGE_SESSIONS,

            self::USER_VIEW,
            self::USER_CREATE,
            self::USER_UPDATE,
            self::USER_DELETE,

            self::ROLE_VIEW,
            self::ROLE_CREATE,
            self::ROLE_UPDATE,
            self::ROLE_DELETE,

            self::EMPLOYEE_VIEW,
            self::EMPLOYEE_CREATE,
            self::EMPLOYEE_UPDATE,
            self::EMPLOYEE_DELETE,

            self::COMPANY_VIEW,
            self::COMPANY_CREATE,
            self::COMPANY_UPDATE,
            self::COMPANY_DELETE,

            self::PRODUCT_VIEW,
            self::PRODUCT_CREATE,
            self::PRODUCT_UPDATE,
            self::PRODUCT_DELETE,

            self::FINANCE_VIEW,
            self::FINANCE_PAY,
            self::FINANCE_REFUND,
        ];
    }
}