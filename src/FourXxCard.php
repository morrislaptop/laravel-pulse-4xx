<?php

namespace Morrislaptop\LaravelPulse4xx;

use Carbon\CarbonImmutable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use Laravel\Pulse\Facades\Pulse;
use Laravel\Pulse\Livewire\Card;
use Laravel\Pulse\Livewire\Concerns;
use Livewire\Attributes\Url;

class FourXxCard extends Card
{
    use Concerns\HasPeriod, Concerns\RemembersQueries;

    /**
     * Ordering.
     *
     * @var 'count'|'latest'
     */
    #[Url(as: '4xx')]
    public string $orderBy = 'count';

    /**
     * Render the component.
     */
    public function render(): Renderable
    {
        [$fourXxRequests, $time, $runAt] = $this->remember(
            fn () => Pulse::aggregate(
                '4xx_request',
                ['max', 'count'],
                $this->periodAsInterval(),
                match ($this->orderBy) {
                    'latest' => 'max',
                    default => 'count'
                },
            )->map(function ($row) {
                [$method, $uri, $status] = json_decode($row->key, flags: JSON_THROW_ON_ERROR);

                return (object) [
                    'method' => $method,
                    'uri' => $uri,
                    'status' => $status,
                    'latest' => CarbonImmutable::createFromTimestamp($row->max),
                    'count' => $row->count,
                ];
            }),
            $this->orderBy,
        );

        return View::make('laravel-pulse-4xx::livewire.4xx', [
            'time' => $time,
            'runAt' => $runAt,
            'fourXxRequests' => $fourXxRequests,
            'config' => [
                'sample_rate' => Config::get('pulse.recorders.'.FourXxRecorder::class.'.sample_rate'),
            ],
        ]);
    }
}
