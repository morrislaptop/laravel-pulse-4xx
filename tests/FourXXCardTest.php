<?php

use Illuminate\Support\Carbon;
use Laravel\Pulse\Facades\Pulse;
use Livewire\Livewire;
use Morrislaptop\LaravelPulse4xx\FourXxCard;

it('includes the card on the dashboard', function () {
    $this
        ->get('/pulse')
        ->assertSeeLivewire(FourXxCard::class);
});

it('renders 4xx requests', function () {
    $request1 = json_encode(['GET', '/users', 418, null]);
    $request2 = json_encode(['GET', '/users/{user}', 403, null]);

    // Add entries outside of the window.
    Carbon::setTestNow('2000-01-01 12:00:00');
    Pulse::record('4xx_request', $request1, now()->timestamp)->max()->count();
    Pulse::record('4xx_request', $request2, now()->timestamp)->max()->count();

    // Add entries to the "tail".
    Carbon::setTestNow('2000-01-01 12:00:01');
    Pulse::record('4xx_request', $request1, now()->timestamp)->max()->count();
    Pulse::record('4xx_request', $request1, now()->timestamp)->max()->count();
    Pulse::record('4xx_request', $request2, now()->timestamp)->max()->count();

    // Add entries to the current buckets.
    Carbon::setTestNow('2000-01-01 13:00:00');
    Pulse::record('4xx_request', $request1, now()->timestamp)->max()->count();
    Pulse::record('4xx_request', $request1, now()->timestamp)->max()->count();
    Pulse::record('4xx_request', $request2, now()->timestamp)->max()->count();

    Pulse::ingest();

    Livewire::test(FourXxCard::class, ['lazy' => false])
        ->assertViewHas('fourXxRequests', collect([
            (object) ['method' => 'GET', 'uri' => '/users', 'status' => 418, 'count' => '4.00', 'latest' => now()],
            (object) ['method' => 'GET', 'uri' => '/users/{user}', 'status' => 403, 'count' => '2.00', 'latest' => now()],
        ]));
});
