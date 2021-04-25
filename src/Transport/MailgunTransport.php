<?php

namespace LeonDeng\LaravelBatchMailgun\Transport;

use Illuminate\Mail\Transport\MailgunTransport as BaseMailgunTransport;
use GuzzleHttp\ClientInterface;
use Swift_Mime_SimpleMessage;

class MailgunTransport extends BaseMailgunTransport
{
  /**
   * Whether enable Mailgun batch sending.
   *
   * @var bool
   */
  protected $batchSending;

  /**
   * Create a new Mailgun transport instance.
   *
   * @param  \GuzzleHttp\ClientInterface  $client
   * @param  string  $key
   * @param  string  $domain
   * @param  string|null  $endpoint
   * @param  bool $batchSending
   * @return void
   */
  public function __construct(ClientInterface $client, $key, $domain, $endpoint = null, $batchSending = false)
  {
    parent::__construct($client, $key, $domain, $endpoint);
    $this->batchSending = $batchSending;
  }

  /**
   * Get the HTTP payload for sending the Mailgun message.
   *
   * @param  \Swift_Mime_SimpleMessage  $message
   * @param  string  $to
   * @return array
   */
  protected function payload(Swift_Mime_SimpleMessage $message, $to)
  {
    // use laravel official mailgun transport when
    // batch_sending in config not set, or
    // only 1 recipient
    if (! $this->batchSending || count($message->getTo()) === 1) {
      return parent::payload($message, $to);
    }

    // batch sending
    $ret = [
      'auth' => [
        'api',
        $this->key,
      ],
      'multipart' => [
        [
          'name' => 'message',
          'contents' => str_replace(
            $message->getHeaders()->get('to')->toString(),
            'To: %recipient%' . PHP_EOL,
            $message->toString()
          ),
          'filename' => 'message.mime',
        ],
      ],
    ];

    $recipients = [];
    foreach ($message->getTo() as $address => $name) {
      $ret['multipart'][] = [
        'name' => 'to',
        'contents' => "$name <$address>",
      ];

      $recipients[$address] = [
        'name' => $name,
      ];
    }

    $ret['multipart'][] = [
      'name' => 'recipient-variables',
      'contents' => json_encode($recipients),
    ];

    return $ret;
  }
}
