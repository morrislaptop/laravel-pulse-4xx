<x-pulse::card :cols="$cols" :rows="$rows" :class="$class">
    <x-pulse::card-header
        name="4XX Requests"
        title="Time: {{ number_format($time) }}ms; Run at: {{ $runAt }};"
        details="past {{ $this->periodForHumans() }}"
    >
        <x-slot:icon>
            <x-pulse::icons.arrows-left-right />
        </x-slot:icon>
        <x-slot:actions>
            <x-pulse::select
                wire:model.live="orderBy"
                label="Sort by"
                :options="[
                    'count' => 'count',
                    'latest' => 'latest',
                ]"
                @change="loading = true"
            />
        </x-slot:actions>
    </x-pulse::card-header>

    <x-pulse::scroll :expand="$expand" wire:poll.5s="">
        @if ($fourXxRequests->isEmpty())
            <x-pulse::no-results />
        @else
            <x-pulse::table>
                <colgroup>
                    <col width="0%" />
                    <col width="100%" />
                    <col width="0%" />
                    <col width="0%" />
                    <col width="0%" />
                </colgroup>
                <x-pulse::thead>
                    <tr>
                        <x-pulse::th>Method</x-pulse::th>
                        <x-pulse::th>Route</x-pulse::th>
                        <x-pulse::th>Status</x-pulse::th>
                        <x-pulse::th class="text-right">Latest</x-pulse::th>
                        <x-pulse::th class="text-right">Count</x-pulse::th>
                    </tr>
                </x-pulse::thead>
                <tbody>
                    @foreach ($fourXxRequests->take(100) as $fourXxRequest)
                        <tr class="h-2 first:h-0"></tr>
                        <tr wire:key="{{ $fourXxRequest->method.$fourXxRequest->uri.$fourXxRequest->status.$this->period }}">
                            <x-pulse::td>
                                <x-pulse::http-method-badge :method="$fourXxRequest->method" />
                            </x-pulse::td>
                            <x-pulse::td class="overflow-hidden max-w-[1px]">
                                <code class="block text-xs text-gray-900 dark:text-gray-100 truncate" title="{{ $fourXxRequest->uri }}">
                                    {{ $fourXxRequest->uri }}
                                </code>
                            </x-pulse::td>
                            <x-pulse::td numeric>{{ $fourXxRequest->status === 418 ? '🫖' : $fourXxRequest->status }}</x-pulse::td>
                            <x-pulse::td numeric class="text-gray-700 dark:text-gray-300 font-bold">
                                {{ $fourXxRequest->latest->ago(syntax: Carbon\CarbonInterface::DIFF_ABSOLUTE, short: true) }}
                            </x-pulse::td>
                            <x-pulse::td numeric class="text-gray-700 dark:text-gray-300 font-bold">
                                @if ($config['sample_rate'] < 1)
                                    <span title="Sample rate: {{ $config['sample_rate'] }}, Raw value: {{ number_format($fourXxRequest->count) }}">~{{ number_format($fourXxRequest->count * (1 / $config['sample_rate'])) }}</span>
                                @else
                                    {{ number_format($fourXxRequest->count) }}
                                @endif
                            </x-pulse::td>
                        </tr>
                    @endforeach
                </tbody>
            </x-pulse::table>

            @if ($fourXxRequests->count() > 100)
                <div class="mt-2 text-xs text-gray-400 text-center">Limited to 100 entries</div>
            @endif
        @endif
    </x-pulse::scroll>
</x-pulse::card>
