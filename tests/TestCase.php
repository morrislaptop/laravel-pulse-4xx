<?php

namespace Morrislaptop\LaravelPulse4xx\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Pulse\PulseServiceProvider;
use Livewire\LivewireServiceProvider;
use Morrislaptop\LaravelPulse4xx\FourXxRecorder;
use Morrislaptop\LaravelPulse4xx\LaravelPulse4xxServiceProvider;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected $enablesPackageDiscoveries = true;

    use WithWorkbench;
    use RefreshDatabase;
}
