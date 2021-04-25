<?php

namespace LeonDeng\LaravelBatchMailgun;

use Illuminate\Mail\TransportManager as BaseTransportManager;
use LeonDeng\LaravelBatchMailgun\Transport\MailgunTransport;

class TransportManager extends BaseTransportManager
{
  /**
   * Create an instance of the Mailgun Swift Transport driver.
   *
   * @return \Illuminate\Mail\Transport\MailgunTransport
   */
  protected function createMailgunDriver()
  {
    $config = $this->app['config']->get('services.mailgun', []);

    return new MailgunTransport(
      $this->guzzle($config),
      $config['secret'],
      $config['domain'],
      $config['endpoint'] ?? null,
      $config['batch_sending'] ?? false
    );
  }
}
