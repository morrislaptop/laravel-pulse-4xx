<p align="center"><img src="/art/screenshot.png" alt="4XX requests for Laravel Pulse"></p>

# Laravel Pulse Card for 4XX responses like validation, auth and not found

[![Latest Version on Packagist](https://img.shields.io/packagist/v/morrislaptop/laravel-pulse-4xx.svg?style=flat-square)](https://packagist.org/packages/morrislaptop/laravel-pulse-4xx)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/morrislaptop/laravel-pulse-4xx/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/morrislaptop/laravel-pulse-4xx/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/morrislaptop/laravel-pulse-4xx/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/morrislaptop/laravel-pulse-4xx/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/morrislaptop/laravel-pulse-4xx.svg?style=flat-square)](https://packagist.org/packages/morrislaptop/laravel-pulse-4xx)

Laravel Pulse Card for 4XX responses like validation, auth and not found.

## Installation

You can install the package via composer:

```bash
composer require morrislaptop/laravel-pulse-4xx
```

## Register the recorder

Add the `FourXxRecorder` to the `config/pulse.php` file. 

```php
return [
    // ...

    'recorders' => [
        Morrislaptop\LaravelPulse4xx\FourXxRecorder::class => [
            'enabled' => env('PULSE_4XX_ENABLED', true),
            'sample_rate' => env('PULSE_4XX_SAMPLE_RATE', 1),
            'ignore' => [
                '#^/wp-admin#', // Classic WordPress...
                '#^/wp-login#',
                '#^/wp-config#',
                '#^/xmlrpc\.php#',
                '#^/browserconfig\.xml#', // Microsoft junk
            ],
        ],

        // ...
    ]
]
```

## Add to your dashboard

To add the card to the Pulse dashboard, you must first [publish the vendor view](https://laravel.com/docs/10.x/pulse#dashboard-customization).

```bash
php artisan vendor:publish --tag=pulse-dashboard
```

Then, add the card to your `resources/views/vendor/pulse/dashboard.php`:

```blade
<x-pulse>
    <livewire:4xx cols="4" rows="2" />

    <!-- ... -->
</x-pulse>
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Craig Morris](https://github.com/morrislaptop)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
