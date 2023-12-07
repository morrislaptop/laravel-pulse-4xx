<?php

use Illuminate\Support\Facades\Gate;
use Morrislaptop\LaravelPulse4xx\Tests\TestCase;

uses(TestCase::class)
    ->beforeEach(function () {
        Gate::define('viewPulse', fn ($user = null) => true);
    })
    ->in(__DIR__);
