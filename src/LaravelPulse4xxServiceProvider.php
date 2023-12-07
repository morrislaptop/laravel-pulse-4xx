<?php

namespace Morrislaptop\LaravelPulse4xx;

use Morrislaptop\LaravelPulse4xx\Commands\LaravelPulse4xxCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelPulse4xxServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-pulse-4xx')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-pulse-4xx_table')
            ->hasCommand(LaravelPulse4xxCommand::class);
    }
}
