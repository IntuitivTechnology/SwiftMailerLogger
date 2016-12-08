# SwiftMailerLoggerBundle

Symfony2 Bundle for logging all emails sent with the SwiftMailer. 

## Installation

Install with composer :
```bash
composer require it/swift-mailer-logger-bundle
```

### Enable the bundle in your project

```php
// app/AppKernel.php
public function registerBundles()
{
    $bundles = array(
        // ...
        new IT\SwiftMailerLoggerBundle\ITSwiftMailerLoggerBundle(),
        // ...
    );
}
```

## Config

Add the following line to your `config.yml` :
```yaml
# app/config/config.yml

it_swift_mailer_logger:
    level:    debug
    type:     rotating_file
    path:     %kernel.logs_dir%/mailer.%kernel.environment%.log
    max_files:      15
#    enable_db_logger: false #Default value : false. Set it to true to enable the database logger
```

## Usage

A log file will automatically be created et filled when you send emails.
Turn ON the database logger to log all emails sent into your database.