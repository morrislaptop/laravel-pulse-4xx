<?php

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Laravel\Pulse\Facades\Pulse;
use Morrislaptop\LaravelPulse4xx\FourXxRecorder;

use function Pest\Laravel\get;

it('captures 4xx requests', function () {
    Date::setTestNow('2000-01-02 03:04:05');
    Route::get('test-route', function () {
        return response('🫖', 418);
    });

    get('test-route');

    Pulse::ignore(fn () => expect(DB::table('pulse_entries')->get())->toHaveCount(1));
    Pulse::ignore(fn () => expect(DB::table('pulse_aggregates')->get())->toHaveCount(8));
    Pulse::ignore(fn () => expect(DB::table('pulse_values')->count())->toBe(0));
});

it('does not capture 2xx requests', function () {
    Config::set('pulse.recorders.'.FourXxRecorder::class.'.enabled', true);
    Date::setTestNow('2000-01-02 03:04:05');
    Route::get('test-route', function () {
        return response('OK');
    });

    get('test-route');

    Pulse::ignore(fn () => expect(DB::table('pulse_entries')->get())->toHaveCount(0));
    Pulse::ignore(fn () => expect(DB::table('pulse_aggregates')->get())->toHaveCount(0));
    Pulse::ignore(fn () => expect(DB::table('pulse_values')->count())->toBe(0));
});
