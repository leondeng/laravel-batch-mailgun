<?php

namespace LeonDeng\LaravelBatchMailgun;

use Illuminate\Mail\MailManager as BaseMailManager;
use LeonDeng\LaravelBatchMailgun\Transport\MailgunTransport;

class MailManager extends BaseMailManager
{
  /**
   * Create an instance of the Mailgun Swift Transport driver.
   *
   * @param  array  $config
   * @return \Illuminate\Mail\Transport\MailgunTransport
   */
  protected function createMailgunTransport(array $config)
  {
    if (!isset($config['secret'])) {
      $config = $this->app['config']->get('services.mailgun', []);
    }

    return new MailgunTransport(
      $this->guzzle($config),
      $config['secret'],
      $config['domain'],
      $config['endpoint'] ?? null,
      $config['batch_sending'] ?? false
    );
  }
}
