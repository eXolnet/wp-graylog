# wp-log
This wordpress plugin is use to add a Wordpress Processor to handle exceptions in a Wordpress site.

It is also installing whoops to add some beauty to the exceptions.

Note: Whoops will be activated if `WP_DEBUG` variable is set to `true`

#Environment Variable
Some environment variables are use by this plugin to know where to send the logs

```
LOG_APP=<APPLICATION_NAME>
LOG_HOST=<LOGGING_APP_HOST>
LOG_PORT=<LOGGING_APP_PORT>
```
