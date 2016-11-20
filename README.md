OroLoggerBundle
===============

This bundle provide ability to log system events.

We use [MonologBundle](https://github.com/symfony/monolog-bundle) for logging events that implements the [PSR-3 LoggerInterface](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md).

Please see Symfony [documentation](http://symfony.com/doc/current/logging.html) for more details how to use [MonologBundle](https://github.com/symfony/monolog-bundle).

### Error logs email notifications
To enable error logs email notification run console command `oro:logger:email-notification` with semicolons separated 
recipients, for example:  

    php app/console oro:logger:email-notification --recipients="admin@example.com;support@example.com"

To disable the notifications run command with `--disable` flag.
  
Or you can configure recipients list using web interface from `System > Configuration > General Setup > Appication Settings > Error Logs 
notifications` section.

To change log level for email notifications update `monolog.handlers.swift.level` parameter at `config_prod.yml`. 

### Temporarily decrease log level
Default log level at production environment is specified by `oro_logger.detailed_logs_default_level` container parameter 
and equals to `error`, you can update it at application configuration.

To find problems you allowed to change this value for a specific time for a specific user, to do this 
run command:  

    php app/console oro:logger:level debug "1 hour" --user=admin@example.com

Where `debug` is log level and `1 hour` is time interval when the level will be used instead of default, 
`--user` option contains email of user whose log will be affected.

Also you can decrease log level system wide by skipping `--user` option.

### Logging Console Commands

All console commands logged automatically on **ConsoleEvents::COMMAND** and **ConsoleEvents::EXCEPTION**, see [ConsoleCommandSubscriber](./EventSubscriber/ConsoleCommandSubscriber.php).

