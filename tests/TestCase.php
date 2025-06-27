<?php

namespace colq2\BladeMjml\Tests;

use colq2\BladeMjml\BladeMjmlServiceProvider;
use Illuminate\Support\Facades\View;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Add your own test views path
        View::addLocation(__DIR__.'/views');

        $this->artisan('view:clear');
    }

    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array<int, class-string<\Illuminate\Support\ServiceProvider>>
     */
    protected function getPackageProviders($app)
    {
        return [
            BladeMjmlServiceProvider::class,
        ];
    }
}
