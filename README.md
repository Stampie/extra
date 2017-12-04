# Stampie Extra

[![Build Status](https://travis-ci.org/Stampie/extra.svg)](https://travis-ci.org/Stampie/extra)

StampieExtra provides an event-based extension point for [Stampie](https://github.com/Stampie/Stampie).
It uses the Symfony EventDispatcher component.

## Usage

The Stampie Extra mailer wraps your Stampie mailer to provides extension points
in the sending process.

```php
<?php

// include the Composer autoloading
require 'vendor/autoload.php';

$httpClient = new Http\Adapter\Guzzle6\Client();
$innerMailer = new Stampie\Mailer\SendGrid($httpClient, 'username:password');

$dispatcher = new Symfony\Component\EventDispatcher\EventDispatcher();
$mailer = new Stampie\Extra\Mailer($innerMailer, $dispatcher);

$message = // Create your Stampie message

$mailer->send($message);
```

The mailer will then dispatch the `stampie.pre_send` event before sending
the message, allowing you to apply some changes.

## Built-in listeners

### ImpersonateListener

The ImpersonateListener allows you to replace the recipient of the mail during
development to send all messages to a single email address. It will add a
`X-Stampie-To` header containing the original recipient.

```php
<?php
$dispatcher->addEventSubscriber(new Stampie\Extra\EventListener\ImpersonateListener('stampie@example.com'));
```

### LoggerListener

The LoggerListener allows you to log sent emails. It expects a logger implementing
the PSR-3 LoggerInterface.

```php
<?php
// create a listener and configure it
$logger = new Monolog\Logger('stampie');
// ...

$dispatcher->addEventSubscriber(new Stampie\Extra\EventListener\LoggerListener($logger));
```

## SpoolMailer

Stampie Extra also provides a SpoolMailer storing the messages in memory and
sending them when flushing the queue.

```php
<?php

$mailer = // Create your mailer...
$spoolMailer = new Stampie\Extra\SpoolMailer($mailer);

$message = // Create your Stampie message...
$spoolMailer->send($message);

// Do some logic, for instance flushing the response to the user

// Flush the queue, sending the message with the inner mailer
$spoolMailer->flushSpool();
```

## Testing

Stampie Extra is [Continuous Integration](http://en.wikipedia.org/wiki/Continuous_integration)
tested with [Travis](https://travis-ci.org) and aims for a high coverage percentage.
