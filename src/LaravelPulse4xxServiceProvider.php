<?php

namespace Morrislaptop\LaravelPulse4xx;

use Illuminate\Contracts\Foundation\Application;
use Livewire\LivewireManager;
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
            ->hasViews('laravel-pulse-4xx');

        $this->callAfterResolving('livewire', function (LivewireManager $livewire, Application $app) {
            $livewire->component('4xx', FourXxCard::class);
        });
    }
}
