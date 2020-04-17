# wp-graylog

[![Software License](https://img.shields.io/badge/license-MIT-8469ad.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/eXolnet/wp-graylog/master.svg?style=flat-square)](https://travis-ci.org/eXolnet/wp-graylog)


Adds a mu-plugin that register a Monolog handler to send exception to a Graylog channel.

It is also installing whoops to add some beauty to the exceptions.

Note: Whoops will be activated if `WP_DEBUG` variable is set to `true`

# Environment Variable
Some environment variables are use by this plugin to know where to send the logs

```
LOG_APP=<APPLICATION_NAME>
LOG_HOST=<LOGGING_APP_HOST>
LOG_PORT=<LOGGING_APP_PORT>
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE OF CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email security@exolnet.com instead of using the issue tracker.

## Credits

- [Simon Gaudreau](https://github.com/Gandhi11)
- [All Contributors](../../contributors)

## License

This code is licensed under the [MIT license](http://choosealicense.com/licenses/mit/). 
Please see the [license file](LICENSE) for more information.
