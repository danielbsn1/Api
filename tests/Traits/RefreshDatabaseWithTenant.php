<?php

namespace Tests\Traits;

use Illuminate\Foundation\Testing\DatabaseMigrations;

trait RefreshDatabaseWithTenant
{
    use DatabaseMigrations;

    /**
     * Define hooks to migrate the database before and after each test.
     */
    protected function setUpRefreshDatabaseWithTenant(): void
    {
        // Clear Spatie permission cache after migrations
        \Artisan::call('permission:cache-reset');
    }
}
