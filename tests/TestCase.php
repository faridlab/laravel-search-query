<?php

namespace GrammaticalQuery\FilterQueryString\Tests;

use Illuminate\Support\Facades\Route;
use GrammaticalQuery\FilterQueryString\Models\User;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->withFactories(__DIR__.'/../database/factories');
        $this->artisan('db:seed');

        $this->defineDefaultRoute();
    }

    private function defineDefaultRoute()
    {
        Route::get('/', function () {
            return User::select('name')->filter()->get();
        });
    }
}