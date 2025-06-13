<?php

namespace colq2\BladeMjml\Tests;

use colq2\BladeMjml\BladeMjmlGlobalContext;
use colq2\BladeMjml\BladeMjmlServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;


class TestCase extends \Orchestra\Testbench\TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

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