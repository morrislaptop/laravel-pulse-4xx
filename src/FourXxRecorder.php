<?php

namespace Morrislaptop\LaravelPulse4xx;

use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Laravel\Pulse\Concerns\ConfiguresAfterResolving;
use Laravel\Pulse\Pulse;
use Laravel\Pulse\Recorders\Concerns;
use Symfony\Component\HttpFoundation\Response;

class FourXxRecorder
{
    use Concerns\Ignores,
        Concerns\Sampling,
        ConfiguresAfterResolving;

    /**
     * Create a new recorder instance.
     */
    public function __construct(
        protected Pulse $pulse,
        protected Repository $config,
    ) {
        //
    }

    /**
     * Register the recorder.
     */
    public function register(callable $record, Application $app): void
    {
        $this->afterResolving(
            $app,
            Kernel::class,
            fn (Kernel $kernel) => $kernel->whenRequestLifecycleIsLongerThan(-1, $record)
        );
    }

    public function record(Carbon $startedAt, Request $request, Response $response): void
    {
        if (! $this->shouldSample()) {
            return;
        }

        $path = $request->path();

        if ($this->shouldIgnore($path)) {
            return;
        }

        $status = $response->getStatusCode();
        $is4xx = $status >= 400 && $status < 500;

        if (! $is4xx) {
            return;
        }

        $this->pulse->record(
            type: '4xx_request',
            key: json_encode([$request->method(), $path, $status], flags: JSON_THROW_ON_ERROR),
            value: $startedAt->getTimestamp(),
            timestamp: $startedAt,
        )->max()->count();
    }
}
