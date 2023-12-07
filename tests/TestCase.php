<?php

namespace Morrislaptop\LaravelPulse4xx\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Pulse\PulseServiceProvider;
use Morrislaptop\LaravelPulse4xx\FourXxRecorder;
use Morrislaptop\LaravelPulse4xx\LaravelPulse4xxServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            PulseServiceProvider::class,
            LaravelPulse4xxServiceProvider::class,
        ];
    }

    protected function defineDatabaseMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../vendor/laravel/pulse/database/migrations');
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('pulse.recorders.'.FourXxRecorder::class.'.sample_rate', 1);
    }
}
