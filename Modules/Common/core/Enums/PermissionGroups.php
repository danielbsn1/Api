<?php

declare(strict_types=1);

namespace Modules\Common\Core\Enums;

enum PermissionGroups: string

{
   

    case AUTH = 'auth';
    case USERS = 'users';
    case ROLES = 'roles';
    case PERMISSIONS = 'permissions';
    case SESSIONS = 'sessions';
    case API_TOKENS = 'api-tokens';
    case OAUTH = 'oauth';
    case MFA = 'mfa';


    case TENANTS = 'tenants';
    case COMPANIES = 'companies';
    case BRANCHES = 'branches';

    

    case EMPLOYEES = 'employees';
    case DEPARTMENTS = 'departments';
    case POSITIONS = 'positions';
    case TEAMS = 'teams';
    case SHIFTS = 'shifts';

   

    case CUSTOMERS = 'customers';
    case LEADS = 'leads';
    case CONTACTS = 'contacts';

  

    case SALES = 'sales';
    case QUOTATIONS = 'quotations';
    case ORDERS = 'orders';
    case INVOICES = 'invoices';

   

    case SUPPLIERS = 'suppliers';
    case PURCHASES = 'purchases';

    

    case PRODUCTS = 'products';
    case CATEGORIES = 'categories';
    case STOCK = 'stock';
    case WAREHOUSES = 'warehouses';

   

    case FINANCE = 'finance';
    case ACCOUNTS_PAYABLE = 'accounts-payable';
    case ACCOUNTS_RECEIVABLE = 'accounts-receivable';
    case CASH_FLOW = 'cash-flow';

    

    case REPORTS = 'reports';
    case DASHBOARDS = 'dashboards';

    

    case SETTINGS = 'settings';
    case THEMES = 'themes';
    case EMAILS = 'emails';
    case NOTIFICATIONS = 'notifications';

   

    case AUDIT = 'audit';
    case LOGS = 'logs';

    

    case MEDIA = 'media';
    case OTHERS = 'others';

    public function module(): string
    {
        return match ($this) {

            self::AUTH,
            self::USERS,
            self::ROLES,
            self::PERMISSIONS,
            self::SESSIONS,
            self::API_TOKENS,
            self::OAUTH,
            self::MFA
                => 'IAM',

            self::TENANTS,
            self::COMPANIES,
            self::BRANCHES
                => 'Organization',

            self::EMPLOYEES,
            self::DEPARTMENTS,
            self::POSITIONS,
            self::TEAMS,
            self::SHIFTS
                => 'Employee',

            self::CUSTOMERS,
            self::LEADS,
            self::CONTACTS
                => 'CRM',

            self::SALES,
            self::QUOTATIONS,
            self::ORDERS,
            self::INVOICES
                => 'Sales',

            self::SUPPLIERS,
            self::PURCHASES
                => 'Purchases',

            self::PRODUCTS,
            self::CATEGORIES,
            self::STOCK,
            self::WAREHOUSES
                => 'Inventory',

            self::FINANCE,
            self::ACCOUNTS_PAYABLE,
            self::ACCOUNTS_RECEIVABLE,
            self::CASH_FLOW
                => 'Finance',

            self::REPORTS,
            self::DASHBOARDS
                => 'Reports',

            self::SETTINGS,
            self::THEMES,
            self::EMAILS,
            self::NOTIFICATIONS
                => 'Settings',

            self::AUDIT,
            self::LOGS
                => 'Audit',

            default
                => 'General',
        };
    }

    public function label(): string
    {
        return match ($this) {

            self::AUTH => 'Authentication',
            self::USERS => 'Users',
            self::ROLES => 'Roles',
            self::PERMISSIONS => 'Permissions',
            self::SESSIONS => 'Sessions',
            self::API_TOKENS => 'API Tokens',
            self::OAUTH => 'OAuth',
            self::MFA => 'Multi-factor Authentication',

            self::TENANTS => 'Tenants',
            self::COMPANIES => 'Companies',
            self::BRANCHES => 'Branches',

            self::EMPLOYEES => 'Employees',
            self::DEPARTMENTS => 'Departments',
            self::POSITIONS => 'Positions',
            self::TEAMS => 'Teams',
            self::SHIFTS => 'Shifts',

            self::CUSTOMERS => 'Customers',
            self::LEADS => 'Leads',
            self::CONTACTS => 'Contacts',

            self::SALES => 'Sales',
            self::QUOTATIONS => 'Quotations',
            self::ORDERS => 'Orders',
            self::INVOICES => 'Invoices',

            self::SUPPLIERS => 'Suppliers',
            self::PURCHASES => 'Purchases',

            self::PRODUCTS => 'Products',
            self::CATEGORIES => 'Categories',
            self::STOCK => 'Stock',
            self::WAREHOUSES => 'Warehouses',

            self::FINANCE => 'Finance',
            self::ACCOUNTS_PAYABLE => 'Accounts Payable',
            self::ACCOUNTS_RECEIVABLE => 'Accounts Receivable',
            self::CASH_FLOW => 'Cash Flow',

            self::REPORTS => 'Reports',
            self::DASHBOARDS => 'Dashboards',

            self::SETTINGS => 'Settings',
            self::THEMES => 'Themes',
            self::EMAILS => 'Emails',
            self::NOTIFICATIONS => 'Notifications',

            self::AUDIT => 'Audit',
            self::LOGS => 'Logs',

            self::MEDIA => 'Media',
            self::OTHERS => 'Others',
        };
    }

    public function description(): string
    {
        return sprintf(
            'Manage permissions related to %s.',
            strtolower($this->label())
        );
    }

    public function icon(): string
    {
        return match ($this) {

            self::AUTH => 'shield-check',
            self::USERS => 'users',
            self::ROLES => 'user-group',
            self::PERMISSIONS => 'key',
            self::SESSIONS => 'computer-desktop',
            self::API_TOKENS => 'command-line',
            self::OAUTH => 'link',
            self::MFA => 'device-phone-mobile',

            self::TENANTS => 'building-office',
            self::COMPANIES => 'building-office-2',
            self::BRANCHES => 'map',

            self::EMPLOYEES => 'identification',
            self::DEPARTMENTS => 'squares-2x2',
            self::POSITIONS => 'briefcase',
            self::TEAMS => 'users',
            self::SHIFTS => 'clock',

            self::CUSTOMERS => 'user',
            self::LEADS => 'sparkles',
            self::CONTACTS => 'address-book',

            self::SALES => 'shopping-cart',
            self::QUOTATIONS => 'document-text',
            self::ORDERS => 'clipboard-document-list',
            self::INVOICES => 'receipt-percent',

            self::SUPPLIERS => 'truck',
            self::PURCHASES => 'shopping-bag',

            self::PRODUCTS => 'cube',
            self::CATEGORIES => 'tag',
            self::STOCK => 'archive-box',
            self::WAREHOUSES => 'home-modern',

            self::FINANCE => 'banknotes',
            self::ACCOUNTS_PAYABLE => 'credit-card',
            self::ACCOUNTS_RECEIVABLE => 'wallet',
            self::CASH_FLOW => 'currency-dollar',

            self::REPORTS => 'chart-bar',
            self::DASHBOARDS => 'presentation-chart-line',

            self::SETTINGS => 'cog-6-tooth',
            self::THEMES => 'paint-brush',
            self::EMAILS => 'envelope',
            self::NOTIFICATIONS => 'bell',

            self::AUDIT => 'shield-exclamation',
            self::LOGS => 'document-magnifying-glass',

            self::MEDIA => 'photo',
            self::OTHERS => 'ellipsis-horizontal',
        };
    }

    public function order(): int
    {
        return array_search($this, self::cases(), true) + 1;
    }

    public static function modules(): array
    {
        $modules = [];

        foreach (self::cases() as $group) {

            $module = $group->module();

            $modules[$module][] = $group;
        }

        return $modules;
    }
}