# Laravel Batch Sending Emails With Mailgun
Enable batch sending of Mailgun transport for Laravel

## Background

Laravel supports Mailgun transport, however it does not support the batch sending feature.
Developers had to use Mailgun SDK for this.
With this package, developers will be able to keep using Mailable classes with Mailgun batch sending.

## Usage
### Require this package

```php
composer require "leondeng/laravel-batch-mailgun"
```

### Configuration
After adding the package, replace the official MailServiceProvider in the providers array in `config/app.php`

```php
Illuminate\Mail\MailServiceProvider::class
```

with

```php
LeonDeng\LaravelBatchMailgun\MailServiceProvider::class
```

Then add batch_sending flag in `config/mail.php`

```php
'batch_sending' => env('MAIL_BATCH_SENDING', false),
```

Then set the env variable `MAIL_BATCH_SENDING` fro your environment.

## License

This package is licensed under the [MIT license](https://github.com/leondeng/laravel-batch-mailgun/blob/master/LICENSE.txt).