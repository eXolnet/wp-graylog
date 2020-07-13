# wp-graylog

[![Software License](https://img.shields.io/badge/license-MIT-8469ad.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/eXolnet/wp-graylog/master.svg?style=flat-square)](https://travis-ci.org/eXolnet/wp-graylog)
[![Latest Stable Version](https://poser.pugx.org/eXolnet/wp-graylog/v/stable?format=flat-square)](https://packagist.org/packages/eXolnet/wp-graylog)
[![Total Downloads](https://img.shields.io/packagist/dt/eXolnet/wp-graylog.svg?style=flat-square)](https://packagist.org/packages/eXolnet/wp-graylog)

Adds a mu-plugin that register a Monolog handler to send exception to a Graylog channel.

## Requirements

* Bedrock
* Composer
* PHP 7.2
* Wordpress

## Installation

Require this package with Composer:

```bash
composer require exolnet/wp-graylog
```

Define the following PHP constants in your `config/application.php` file:

```php
/**
 * wp-graylog
 *
 * Here you may configure the Graylog channel for your application. Behind the
 * scene, it uses the Monolog PHP logging library.
 */
Config::define('GRAYLOG_TRANSPORT', env('GRAYLOG_TRANSPORT'));
Config::define('GRAYLOG_HOST', env('GRAYLOG_HOST'));
Config::define('GRAYLOG_PORT', env('GRAYLOG_PORT'));
Config::define('GRAYLOG_LEVEL', env('GRAYLOG_LEVEL'));
```

Then, update your `.env` to add `GRAYLOG_HOST` environment variable:

```
GRAYLOG_HOST=localhost
```

## Usage

Once installed, errors occurring in your code with a level higher or equals to the `GRAYLOG_LEVEL` will be sent to
the specified Graylog instance. You’ll then be able to centralize all your logs in one place.

### Supported Transports

The following transports are supported: `UDP`, `TCP`, `SSL`, `HTTP` and `HTTPS`. Select the transport accordingly to
your Graylog set up using the `GRAYLOG_TRANSPORT` configuration. By default, the `UDP` transport is used.

The default path for `HTTP` and `HTTPS` transports is `/gelf`. This value can be configured using the `GRAYLOG_PATH`
configuration.

```php
Config::define('GRAYLOG_PATH', env('GRAYLOG_PATH', '/path/to/gelf'));
```

### Application Name

By default, the blog name is used as the application name, but you can overwrite it with the variable `GRAYLOG_APP`:

```php
Config::define('GRAYLOG_APP', 'custom-app-name');
```

### Disable Default Error Handler

By default, if a `GRAYLOG_HOST` is configured, a PHP error handler will be configured to send all errors to Graylog.
This behaviour can be disabled by configuring the following environment variable:

```php
Config::define('GRAYLOG_INITIALIZE_ERROR_HANDLER', false);
```

### Capturing Errors

You can either capture a caught exception or capture the last error:

```php
try {
    $this->functionFailsForSure();
} catch (\Throwable $exception) {
    \Exolnet\Wordpress\Graylog\WpGraylog::captureException($exception);
}

// OR

\Exolnet\Wordpress\Graylog\WpGraylog::captureLastError();
```

## Testing

To run PHPUnit tests, please use:

```bash
composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE OF CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email security@exolnet.com instead of using the issue tracker.

## Credits

- [Simon Gaudreau](https://github.com/Gandhi11)
- [Alexandre D’Eschambeault](https://github.com/xel1045)
- [All Contributors](../../contributors)

## License

This code is licensed under the [MIT license](http://choosealicense.com/licenses/mit/). 
Please see the [license file](LICENSE) for more information.
