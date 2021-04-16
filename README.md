# Laravel Batch Sending Emails With Mailgun
Enable batch sending of Mailgun transport for Laravel

## Background

Laravel supports Mailgun transport, however it does not support batch sending. Developers had to user Mailgun SDK for this.
With this package, developers are able to still use Mailable classes for their mailing logic with batch sending enabled.

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